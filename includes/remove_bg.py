#!/usr/bin/env python3
"""
AI background removal — single best output.
Scene: anime | general | portrait
"""
from __future__ import annotations

import json
import sys
import warnings
from pathlib import Path

import numpy as np
from PIL import Image, ImageFilter
from rembg import new_session, remove

warnings.filterwarnings("ignore")

MODEL_FALLBACKS = {
    "isnet-anime": ["isnet-general-use", "u2net"],
    "isnet-general-use": ["u2net", "isnet-anime"],
    "u2net_human_seg": ["u2net", "isnet-general-use"],
    "u2net": ["isnet-general-use"],
}

_SESSIONS: dict = {}


def get_session(model_name: str):
    if model_name not in _SESSIONS:
        _SESSIONS[model_name] = new_session(model_name)
    return _SESSIONS[model_name]


def load_rgba(path: Path) -> Image.Image:
    img = Image.open(path).convert("RGBA")
    max_dim = 1800
    if max(img.size) > max_dim:
        img.thumbnail((max_dim, max_dim), Image.Resampling.LANCZOS)
    return img


def run_model(img: Image.Image, model_name: str) -> tuple[Image.Image, str]:
    candidates = [model_name] + MODEL_FALLBACKS.get(model_name, ["u2net"])
    last_err = None
    for name in candidates:
        try:
            session = get_session(name)
            out = remove(img, session=session, alpha_matting=False).convert("RGBA")
            return out, name
        except Exception as exc:  # noqa: BLE001
            last_err = exc
            _SESSIONS.pop(name, None)
    raise RuntimeError(f"All models failed for {model_name}: {last_err}")


def odd_size(n: int) -> int:
    n = max(3, int(n))
    return n if n % 2 == 1 else n + 1


def morph_max(alpha: np.ndarray, size: int) -> np.ndarray:
    a = Image.fromarray(np.clip(alpha, 0, 255).astype(np.uint8), mode="L")
    a = a.filter(ImageFilter.MaxFilter(odd_size(size)))
    return np.array(a, dtype=np.float32)


def morph_min(alpha: np.ndarray, size: int) -> np.ndarray:
    a = Image.fromarray(np.clip(alpha, 0, 255).astype(np.uint8), mode="L")
    a = a.filter(ImageFilter.MinFilter(odd_size(size)))
    return np.array(a, dtype=np.float32)


def close_holes(alpha: np.ndarray, radius: int = 9) -> np.ndarray:
    return morph_min(morph_max(alpha, radius), radius)


def blur_alpha(alpha: np.ndarray, radius: float) -> np.ndarray:
    a = Image.fromarray(np.clip(alpha, 0, 255).astype(np.uint8), mode="L")
    a = a.filter(ImageFilter.GaussianBlur(radius=radius))
    return np.array(a, dtype=np.float32)


def merge_cutouts(a: Image.Image, b: Image.Image, weight_b: float = 0.98) -> Image.Image:
    aa = np.array(a)
    bb = np.array(b)
    if aa.shape != bb.shape:
        return a
    alpha = np.maximum(aa[..., 3].astype(np.float32), bb[..., 3].astype(np.float32) * weight_b)
    out = aa.copy()
    prefer = bb[..., 3] > aa[..., 3]
    out[prefer, :3] = bb[prefer, :3]
    out[..., 3] = np.clip(alpha, 0, 255).astype(np.uint8)
    return Image.fromarray(out, "RGBA")


def finalize(merged: Image.Image) -> Image.Image:
    """Balanced cleanup: fill holes, light feather, drop haze."""
    arr = np.array(merged)
    alpha = arr[..., 3].astype(np.float32)
    alpha = close_holes(alpha, radius=9)
    alpha = blur_alpha(alpha, radius=0.9)
    alpha[alpha < 12] = 0
    mid = (alpha >= 12) & (alpha < 50)
    alpha[mid] = np.clip(alpha[mid] * 1.25, 0, 255)
    arr[..., 3] = np.clip(alpha, 0, 255).astype(np.uint8)
    return Image.fromarray(arr, "RGBA")


def primary_model_for_scene(scene: str) -> str:
    return {
        "anime": "isnet-anime",
        "portrait": "u2net_human_seg",
        "general": "isnet-general-use",
    }.get(scene, "isnet-anime")


def boost_model_for_scene(scene: str) -> str:
    return {
        "anime": "isnet-general-use",
        "portrait": "isnet-general-use",
        "general": "isnet-anime",
    }.get(scene, "isnet-general-use")


def main():
    if len(sys.argv) < 3:
        print(json.dumps({"ok": False, "error": "Usage: remove_bg.py <input> <outdir> [scene]"}))
        sys.exit(1)

    src_path = Path(sys.argv[1])
    out_dir = Path(sys.argv[2])
    scene = (sys.argv[3] if len(sys.argv) > 3 else "anime").strip().lower()
    if scene not in ("anime", "general", "portrait"):
        scene = "anime"

    out_dir.mkdir(parents=True, exist_ok=True)

    try:
        src = load_rgba(src_path)
        primary_img, used_primary = run_model(src, primary_model_for_scene(scene))
        boost_img, used_boost = run_model(src, boost_model_for_scene(scene))
        merged = merge_cutouts(primary_img, boost_img)
        result = finalize(merged)
        result.save(out_dir / "result.png", "PNG", optimize=True)

        print(json.dumps({
            "ok": True,
            "scene": scene,
            "models": {"primary": used_primary, "boost": used_boost},
        }))
    except Exception as exc:  # noqa: BLE001
        print(json.dumps({"ok": False, "error": str(exc)}))
        sys.exit(1)


if __name__ == "__main__":
    main()
