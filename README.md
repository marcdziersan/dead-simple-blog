# 🧱 Dead Simple Blog (Extended Version)

A no-dependency, flat-file PHP blog system that uses Markdown for content and JSON for optional comments. This is a fork and extended version of the original [Painted Sky Studios](https://github.com/paintedsky) concept – kept minimal but expanded where needed.

## ✨ Features

- Flat-file blog posts (Markdown-formatted `.txt` or `.md`)
- No database, no framework, no build step
- Themeable via `/themes` directory
- Optional threaded comment system (saved as JSON)
- Clean, responsive design with modern `style.css`
- Configurable via a single `config.php` file
- MIT licensed & open source

---

## 💡 Philosophy
Original:
I've wanted for a long time to create a simple way of blogging that eschews basically all bells and whistles. Many "flat file" Content Management Systems exist already, as well as "static site generators", but none of these that I looked at were simple enough for my liking.

I don't want to have to install Ruby, or Python, or Composer, or whatever else on a server to run a blog. On the other hand, installing WordPress or one of the other popular PHP-based CMSes for this use case is like hammering in a nail with a sledgehammer.

Many people dislike PHP, and while it has its warts, I like it. I like using (vanilla) PHP simply because it is nearly ubiquitous. Having to install or configure it is often unnecessary because it is usually already installed, configured, and running.

I wanted to use plain text files, but some formatting is nice -- Markdown was the obvious solution for this, since it offers quite a lot of options in terms of text formatting, without sacrificing the readability of the plain text itself. I was not keen on adding dependencies but I found Parsedown which offers Markdown parsing by including a single PHP file. I can deal with that.

That's really all there is to it -- dead simple PHP-based templating, and Markdown-formatted plain text content.

I know I'm probably forgetting about a million edge cases, but I want to keep it simple. So, we'll roll with this for now and add features as they become necessary.

Enhanced:
>> This version continues that spirit – with a few modern improvements like replies, styling, and structure.

---

## 📦 Installation

1. Clone or download this repo.
2. Upload to any PHP-compatible webhost (Apache, nginx, localhost).
3. That’s it. No dependencies, no setup.

---

## 🛠 Configuration

Open `config.php` and adjust these:

```php
$base_url = './';
$blog_title = 'your title';
$blog_theme = 'modern';
$blog_comment = false;
$contact_name = 'Max Mustermann';
$contact_street = 'Max-Mustermann-Str. 123';
$contact_city = '12345 Musterstadt';
$contact_country = 'Deutschland';
$contact_email = 'your email';
$contact_number = '+0123456789';
```
<a href="https://github.com/paintedsky/dead-simple-blog">paintedsky Original</a><br>
<a href="https://github.com/shoaiyb/dead-simple-blog">shoaiyb -> Theme and disqus</a><br>
<a href="https://github.com/marcdziersan/dead-simple-blog">marcdziersan -> Theme and own comments system</a>
