# 📝 CHANGELOG

## 2025-07-11

- 📝 Updated Parsedown 1.8.0 http://parsedown.org

## 2025-07-09  
**Marcus Dziersan – Extension of the fork with a custom comment system**

- ✨ Custom comment system with JSON storage (`/comments/[id].json`)
- 💬 Support for replies to comments (1-level threaded)
- 🔘 Collapsible reply forms via JavaScript toggle
- 📥 New `save_comment.php` with `parent` and `id` logic
- 🧾 Secure validation and storage of form inputs
- 🎨 Fully modern and responsive `style.css` with clean UI
- 🧩 Comment system can be toggled via `config.php` (`$blog_comment`)
- 🧱 Improved HTML and CSS structure for better readability
- 📄 New pages: `imprint.php`, `policy.php` using the same layout
- 📜 Updated MIT License: Marcus Dziersan added as contributor
- 🔧 General enhancements & minor bug fixes
- 🔧 Back to overview link
- 🚀 Build own theme
- Mini Admin Backend
- Image Upload in Admin backend

---

## 2022  
**Shoaiyb Sysa – Fork of the original by Painted Sky Studios**

- Code structure cleanup
- Prepared for theme support
- General enhancements & minor bug fixes

---

## 2018  
**Painted Sky Studios – Original version**

- ✅ Updated Parsedown to v1.7.4
- 🔧 Split configuration: `config-default.php` + `config-custom.php`
- 🌙 Introduced dark mode via `APPEARANCE` constant
- 📄 Changed default file extension to `.md` (configurable via `FILE_EXT`)
- 🗂 Restructured folders: CSS and fonts moved to `/src`
- 📝 Updated content in `AboutDrafts.md`
- 🐛 Defined `$content` in global scope (fix for certain PHP setups)
- 🖼 Added default favicon at `/img/favicon.png`
- 🚀 Improved font and CSS caching by using `<link>` instead of `@import`
- 🧠 Switched to semantic `<main>` for list view and `<article>` for single post
- 🔃 Posts are now explicitly sorted using `sortPosts()` (default: descending by filename)

---
