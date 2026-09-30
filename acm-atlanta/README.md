# ACM Atlanta Professional Chapter — Website

Official website for the **ACM Atlanta Professional Chapter**, serving Atlanta and the greater metro Atlanta technology community.

🌐 **Live site:** [https://atlanta.acm.org](https://atlanta.acm.org)  
📁 **Repository:** [https://github.com/gsadaram144/atlantaacmchapter](https://github.com/gsadaram144/atlantaacmchapter)

---

## Table of Contents

1. [Project Overview](#project-overview)
2. [Tech Stack](#tech-stack)
3. [Prerequisites](#prerequisites)
4. [Local Development Setup](#local-development-setup)
5. [Project Structure](#project-structure)
6. [Development Workflow](#development-workflow)
7. [Deploying to Production](#deploying-to-production)
8. [WordPress Admin Guide](#wordpress-admin-guide) — Events, Officers, and page management
9. [Cloudflare Turnstile Configuration](#cloudflare-turnstile-configuration)
10. [Design System](#design-system)
11. [Credentials & Access](#credentials--access)
12. [Troubleshooting](#troubleshooting)

---

## Project Overview

The ACM Atlanta website is built on **WordPress** with a fully custom child theme called `acm-atlanta`. All styling is organized into modular CSS files and loaded globally — meaning changes to shared styles automatically apply across every page.

The site is hosted by ACM Global at `atlanta.acm.org`. The WordPress admin and cPanel are accessed via IP address (see [Credentials & Access](#credentials--access)).

---

## Tech Stack

| Layer | Technology |
|---|---|
| CMS | WordPress (hosted by ACM) |
| Theme | Custom child theme (`acm-atlanta`) |
| Languages | PHP, CSS, JavaScript |
| Fonts | Merriweather (serif) + Source Sans 3 (sans-serif) via Google Fonts |
| Local Dev | Local by Flywheel |
| Version Control | Git + GitHub |
| Deployment | GitHub Actions (auto-deploy on merge to `main`) |

---

## Prerequisites

Before you begin, install the following on your machine. Each item links to its download page.

| Tool | Purpose | Download |
|---|---|---|
| **VS Code** | Code editor | [code.visualstudio.com](https://code.visualstudio.com) |
| **Local by Flywheel** | Run WordPress locally on your Mac | [localwp.com](https://localwp.com) |
| **Git** | Version control | [git-scm.com](https://git-scm.com) |

### VS Code Extensions (Required)

Open VS Code and install these extensions (`Cmd+Shift+X` to open Extensions panel):

| Extension | Publisher | Purpose |
|---|---|---|
| **PHP Intelephense** | Ben Mewburn | PHP autocomplete |
| **Prettier** | Prettier | Auto-format code |
| **GitLens** | GitKraken | Git history in editor |

---

## Local Development Setup

Follow these steps exactly, in order.

> **The key idea:** We create the Local site first, then pull the repo directly into that same folder. This means your code editor, Git, and local WordPress all point to the **same directory** — no copying or syncing ever needed.

### Step 1 — Create a New Site in Local by Flywheel

1. Open **Local by Flywheel**
2. Click the **"+"** button (bottom left) → **"Create New Site"**
3. Fill in:
   - Site name: `acm-atlanta` ← must be exactly this
   - Click **"Continue"**
   - Choose **"Preferred"** environment
   - Click **"Continue"**
   - Set a WordPress username and password you'll remember
   - Click **"Add Site"**
4. Wait for Local to finish (takes ~1 minute)
5. Click **"Open Site"** to confirm WordPress loads at `http://acm-atlanta.local`

This creates the directory `~/Local Sites/acm-atlanta/` with WordPress already inside it.

### Step 2 — Pull the Repo into the Local Site Directory

Now pull the project code directly into that same Local site folder:

```bash
cd ~/Local\ Sites/acm-atlanta/
git init
git remote add origin git@github.com:gsadaram144/atlantaacmchapter.git
git pull origin main
```

> **SSH required:** This uses SSH to authenticate with GitHub. If you get an error, see [Git push fails with authentication error](#git-push-fails-with-authentication-error) in the Troubleshooting section.

Your theme files are now live at:
```
~/Local Sites/acm-atlanta/app/public/wp-content/themes/acm-atlanta/
```

VS Code, Git, and Local by Flywheel all work from the same root folder. ✅

### Step 3 — Activate the Theme

1. In Local, click **"WP Admin"** to open the WordPress dashboard
2. Go to **Appearance → Themes**
3. Find **ACM Atlanta** and click **Activate**

### Step 4 — Set the Homepage

1. Go to **Settings → Reading**
2. Select **"A static page"**
3. Set **Front page** to **Home** (create a blank page called "Home" if it doesn't exist yet)
4. Click **Save Changes**

### Step 5 — Set Up Navigation Menu

1. Go to **Appearance → Menus**
2. Click **"Create a new menu"**
3. Name it `Primary Navigation`
4. Add pages: Home, About, Events, Officers, Membership, Contact
5. Under **"Menu Settings"** check **Primary Navigation**
6. Click **Save Menu**

### Step 6 — Open the Project in VS Code

Open VS Code at the **site root** (not just the theme folder):

```bash
code ~/Local\ Sites/acm-atlanta/
```

You should see `app/`, `conf/`, `logs/` in the VS Code sidebar.

### Step 7 — Verify Everything Works

Visit `http://acm-atlanta.local` in your browser. You should see the ACM Atlanta homepage with:
- Sticky header with logo and navigation
- Hero section with blue overlay
- Purpose Pillars section
- Membership section
- Events section
- Footer with social icons

> **Note:** Images (logo, hero banner) load from the production server URLs, so they may not display locally. This is expected. They will display correctly on the live site.

---

## Project Structure

```
acm-atlanta/                              ← Open THIS folder in VS Code
│
├── .vscode/
│   └── sftp.json                        ← SFTP config (DO NOT COMMIT)
│
├── app/
│   └── public/                          ← WordPress root
│       └── wp-content/
│           └── themes/
│               └── acm-atlanta/          ← 👈 Your theme (edit files here)
│                   │
│                   ├── style.css        ← Theme declaration (required by WordPress)
│                   ├── functions.php    ← Enqueue CSS/JS, register menus
│                   ├── index.php        ← Fallback template
│                   ├── header.php       ← Site-wide header & navigation
│                   ├── footer.php       ← Site-wide footer
│                   ├── front-page.php   ← Homepage template (shows next 3 upcoming events)
│                   ├── single-acm_event.php ← Individual event page (auto-used by WordPress)
│                   │
│                   ├── css/
│                   │   ├── variables.css        ← ⭐ Colors, fonts, spacing — edit this to restyle everything
│                   │   ├── typography.css        ← Headings, body text, links
│                   │   ├── buttons.css           ← All button styles
│                   │   ├── header.css            ← Sticky nav styles
│                   │   ├── footer.css            ← Footer styles
│                   │   ├── layout.css            ← Sections, cards, grids
│                   │   ├── registrations.css     ← Event registration form styles
│                   │   └── responsive.css        ← All media queries (mobile/tablet)
│                   │
│                   ├── inc/
│                   │   └── event-registrations.php  ← Registration DB, form handler, admin page
│                   │
│                   ├── js/
│                   │   └── main.js               ← Mobile menu toggle, smooth scroll
│                   │
│                   ├── page-about.php            ← About page (auto-loads for slug: about)
│                   ├── page-events.php           ← Events listing page (auto-loads for slug: events)
│                   ├── page-officers.php         ← Officers page with selector UI (auto-loads for slug: officers)
│                   ├── page-membership.php       ← Membership page (auto-loads for slug: membership)
│                   ├── page-contact.php          ← Contact page (auto-loads for slug: contact)
│                   │
│                   ├── page-templates/
│                   │   └── events.php            ← Legacy template (superseded by page-events.php)
│                   │
│                   └── template-parts/
│                       └── event-card.php        ← ⭐ Shared event card — used by homepage and events page
│
├── conf/                                ← Local by Flywheel config (don't edit)
├── logs/                                ← Local by Flywheel logs (don't edit)
├── .gitignore                           ← Excludes credentials, WP core, uploads
├── CONTRIBUTING.md                      ← Contribution and PR workflow guide
└── README.md                            ← You are here
```

---

## Development Workflow

### Day-to-Day Editing

```
1. Open VS Code at ~/Local Sites/acm-atlanta/
        ↓
2. Pull latest changes from main
        git checkout main && git pull origin main
        ↓
3. Create a new branch for your work
        git checkout -b feature/your-change
        ↓
4. Edit theme files in app/public/wp-content/themes/acm-atlanta/
        ↓
5. Preview changes at http://acm-atlanta.local (instant, no upload needed)
        ↓
6. Commit and push your branch
        git add .
        git commit -m "describe what you changed"
        git push origin feature/your-change
        ↓
7. Open a Pull Request on GitHub for review
        ↓
8. Once approved and merged, deploy to production (see below)
```

> **Never push directly to `main`.** All changes go through a Pull Request.
> See [CONTRIBUTING.md](CONTRIBUTING.md) for the full contribution guide.

### Common Edits

| What you want to change | Which file to edit |
|---|---|
| Brand colors | `css/variables.css` — edit `--blue`, `--gold` etc. |
| Font sizes | `css/variables.css` — edit `--text-*` variables |
| Navigation links | `header.php` or **WP Admin → Appearance → Menus** |
| Footer links | `footer.php` |
| Homepage content | `front-page.php` |
| Button styles | `css/buttons.css` |
| Mobile layout | `css/responsive.css` |
| Add a new page | Create `page-yourslug.php` in the theme root (auto-loads for pages with that slug) |

### Git Best Practices

Always pull before starting work to get latest changes:
```bash
git checkout main
git pull origin main
```

Always work on a branch — never commit directly to `main`:
```bash
git checkout -b feature/your-change
```

Write descriptive commit messages:
```bash
# Good
git commit -m "feat: update hero headline copy and button text"
git commit -m "feat: add About page template"
git commit -m "fix: correct mobile navigation menu overlap"

# Bad
git commit -m "update"
git commit -m "fix"
```

For the full contribution workflow including how to open a Pull Request, see [CONTRIBUTING.md](CONTRIBUTING.md).

---

## Deploying to Production

Deployment is **fully automated via GitHub Actions**. Every time a PR is merged into `main`, GitHub detects changes to theme files and automatically FTPs them to the production server. No manual steps needed.

```
PR merged into main
        ↓
GitHub Actions detects changes in themes/acm-atlanta/**
        ↓
FTP-Deploy-Action uploads only changed files to production
        ↓
Live site updated automatically ✅
```

You can watch deployments run in real time under the **Actions** tab on GitHub:
`https://github.com/gsadaram144/atlantaacmchapter/actions`

### How It Works

The workflow lives at `.github/workflows/deploy.yml` (in the repository root, one level above this README) and uses [SamKirkland/FTP-Deploy-Action@v4.3.6](https://github.com/SamKirkland/FTP-Deploy-Action). It:

- Triggers **only on pushes to `main`** — branch pushes (PRs in progress) are ignored
- Can also be run manually from **Actions → Deploy theme → Run workflow**
- Triggers **only when theme files change** — pushes to README, CONTRIBUTING, etc. skip deployment
- Uploads only the **diff** (changed files only), not the full theme on every run
- Excludes `.git`, `.DS_Store`, and `node_modules` automatically

### GitHub Secrets Required

The workflow reads credentials from GitHub Secrets — never stored in the repo. These are already configured, but if they ever need to be updated go to:

**GitHub → Settings → Secrets and variables → Actions**

| Secret Name | What it stores |
|---|---|
| `FTP_HOST` | `<YOUR-HOSTING-IP>` |
| `FTP_USERNAME` | `atlantahosting` |
| `FTP_PASSWORD` | cPanel FTP password |
| `FTP_SERVER_DIR` | *(optional)* Remote theme folder — defaults to `public_html/wp-content/themes/acm-atlanta/` |
| `FTP_PROTOCOL` | *(optional)* `ftps` (default) or `ftp` if the server doesn't support TLS |

### First-Time Hosting Setup

Do these once before the first automated deploy:

1. **Request chapter hosting from ACM** — email ACM Tech Support (technicalsupport@acm.org) to get the `atlanta.acm.org` subdomain, WordPress install, and cPanel/FTP credentials for the chapter.
2. **Install WordPress** on the hosting account (cPanel → Softaculous/WordPress installer) if ACM hasn't already.
3. **Add the GitHub Secrets** listed above.
4. **Run the first deploy** — Actions → Deploy theme → Run workflow.
5. **Activate the theme** — WP Admin → Appearance → Themes → ACM Atlanta → Activate.
6. **Create the pages** with slugs `about`, `events`, `officers`, `membership`, `contact` and set a static homepage (Settings → Reading).
7. **Upload the logo and icon images** — the header, footer and homepage banner load images from `https://atlanta.acm.org/wp-content/uploads/2026/03/…`. Upload those files to the Media Library and make sure the URLs in `header.php`, `footer.php`, `front-page.php` and `page-about.php` match where WordPress stored them.
8. **Add the officers** (see [Managing Officers](#managing-officers)).

### After Deploying

Visit [https://atlanta.acm.org](https://atlanta.acm.org) and verify your changes look correct. If something looks wrong:
1. Check the **Actions** tab on GitHub for error logs
2. Hard refresh the browser (`Cmd+Shift+R`) to clear cache

### Emergency Manual Deploy

If GitHub Actions is down or you need to deploy a hotfix immediately without going through a PR, you can still deploy manually via VS Code:

1. Install the **SFTP** extension by Natizyskunk in VS Code
2. Ensure `sftp.json` is configured (see credentials reference below)
3. `Cmd+Shift+P` → **SFTP: Upload Project**

---

## WordPress Admin Guide

### Accessing the Dashboard

- **Local (development):** `http://acm-atlanta.local/wp-admin`
- **Production:** `https://atlanta.acm.org/wp-admin`

---

### Managing Events

Events are the most frequently updated part of the site. They are managed through a custom **Events** post type in WP Admin — no code changes needed.

#### How the Events System Works

| URL | What it does |
|---|---|
| `/events/` | Lists all upcoming events (3 per page), then past events (3 per page) |
| `/events/my-event-slug/` | Individual event detail page, auto-generated by WordPress |

- **Upcoming events** are sorted soonest first
- **Past events** appear automatically once the event date passes — most recently completed first
- Both sections paginate independently (clicking through past events doesn't affect upcoming, and vice versa)
- The homepage shows the next 3 upcoming events automatically

#### Adding a New Event

1. Go to **WP Admin → Events → Add New**
2. Enter the **event title** at the top (e.g. "AI & Machine Learning Panel")
3. In the **block editor** (main content area), write the full event description — agenda, speakers, what attendees can expect, parking info, etc.
4. Fill in the **Event Details** box below the editor:

| Field | Example | Notes |
|---|---|---|
| Event Date | `04/17/2026` | Required — controls upcoming vs past sorting |
| Time | `6:00 – 8:30 PM` | Displayed on event card and detail page |
| Location | `Venue TBA – Atlanta, GA` | Displayed on event card and detail page |
| Ticket / Entry Info | `Free for Members` | Shown on card and sidebar |
| RSVP / Registration URL | `https://eventbrite.com/...` | Powers the RSVP button — leave blank to show Details only |

5. Click **Save** (top right)

> ⚠️ **Turn off starter patterns** in the block editor to avoid unwanted layout templates being applied. Go to the **three-dot menu (⋮) → Preferences → General → turn off "Show starter patterns"**.

#### Editing an Existing Event

1. Go to **WP Admin → Events**
2. Click the event title to open it
3. Update any fields in the editor or Event Details box
4. Click **Save**

Changes appear immediately on both the events listing page and the individual event page.

#### How Past Events Work

You never need to manually move an event to "past" — the site compares `_event_date` against today's date on every page load:

- If the event date is **today or in the future** → shown in Upcoming Events
- If the event date has **already passed** → automatically shown in Past Events, most recent first
- On the individual event page, the RSVP button is automatically replaced with "This event has already taken place"

#### Troubleshooting: Event Page Shows Blank or Wrong Layout

If `/events/your-event-slug/` shows a blank page or the wrong layout:

1. Go to **WP Admin → Settings → Permalinks**
2. Click **Save Changes** (no changes needed — this flushes URL routing rules)
3. Refresh the event page

This is required any time the Events post type is first registered on a new WordPress install.

---

### Managing Event Registrations

Attendees can register for upcoming events directly on the event detail page. Registrations are stored privately and never shown to the public.

#### Viewing Registrations

1. Go to **WP Admin → Events → Registrations**
2. Use the **Filter by Event** dropdown to select an event
3. Click **View** — the table below shows all registrants with name, email, phone, and registration timestamp

#### Exporting to CSV

With an event selected, click **Export CSV** to download a spreadsheet of all registrants for that event. Use this to send event reminders or follow-up emails.

#### Deleting Spam or Test Registrations

1. Check the box next to any rows you want to remove (use the header checkbox to select all)
2. Click **Delete Selected** and confirm the prompt
3. A success notice confirms how many rows were removed

> **Note:** Cloudflare Turnstile protects the registration form against bots. See [Cloudflare Turnstile Configuration](#cloudflare-turnstile-configuration) for setup.

---

### Managing Officers

Officer profiles are managed through a custom **Officers** post type in WP Admin — no code changes needed.

#### Adding a New Officer

1. Go to **WP Admin → Officers → Add New**
2. Enter the **officer's full name** as the title
3. Write their **bio** in the block editor (main content area)
4. Fill in the **Officer Details** box below the editor:

| Field | Example | Notes |
|---|---|---|
| Role / Title | `Chair` | Required — shown as the role badge. Pick from the suggestions (Chair, Vice Chair, Secretary, Treasurer, Membership Chair, Program Chair) or type a custom title |
| Display Order | `1` | Controls left-to-right order on the Officers page (1 = first) |
| Duties & Responsibilities | `Leads the chapter, chairs officer meetings...` | Shown in the detail panel |
| Email Address | `chair@atlanta.acm.org` | Shown as a mailto button |
| LinkedIn URL | `https://linkedin.com/in/...` | Shown as a LinkedIn button |

5. Set the **Featured Image** (right sidebar) — this becomes the officer's photo
6. Click **Publish**

> 💡 If no photo is set, a placeholder circle with the officer's initial displays automatically.

#### Display Order

Set **Display Order** to control the sequence of buttons on the Officers page:
- Chair → `1`
- Vice Chair → `2`
- Secretary → `3`
- Treasurer → `4`
- Membership Chair → `5`
- Program Chair → `6`

#### Before Officers Are Added

Until at least one officer is published, the Officers page shows the core positions (Chair, Vice Chair, Secretary, Treasurer) as **To Be Announced**. The standard role names and default responsibilities live in `acm_atlanta_officer_roles()` in `functions.php`.

---

### Adding Pages

1. Go to **Pages → Add New**
2. Give it a title (e.g. "About", "Officers")
3. Add content using the WordPress block editor
4. Click **Publish**
5. Go to **Appearance → Menus** and add the new page to the navigation

---

### Updating Social Media Links

Social links are hardcoded in `footer.php`. To update them:

1. Open `footer.php` in VS Code
2. Find the `$socials` array near the top of the footer section
3. Replace `'#'` with the actual social media URL for each platform
4. Save and deploy

---

## Cloudflare Turnstile Configuration

The event registration form is protected by [Cloudflare Turnstile](https://www.cloudflare.com/products/turnstile/) — a free, privacy-friendly bot challenge that stops automated submissions without showing users a CAPTCHA puzzle.

### How the Keys Work

| Key | Visibility | Purpose |
|---|---|---|
| **Site key** | Public — embedded in the page HTML | Tells Cloudflare which widget to render |
| **Secret key** | Private — never share or commit | Verifies the challenge server-side |

### Local Development

Turnstile is **automatically bypassed** on local environments (`WP_ENVIRONMENT_TYPE = 'local'`). No keys are needed for local development — the registration form works without any configuration.

### Production Setup

After deploying to production, configure both keys once through WP Admin:

1. Go to **WP Admin → Events → Registrations**
2. Expand **Turnstile Settings** at the top of the page
3. Enter your **Site Key** and **Secret Key**
4. Click **Save Keys**

Keys are stored in the WordPress database — no file editing or server access needed.

### Getting Your Keys

1. Go to **[dash.cloudflare.com](https://dash.cloudflare.com)**
2. Select your account from the account picker
3. In the left sidebar, click **Turnstile** (under the "Security" group)  
   → Direct path: `dash.cloudflare.com → [Your Account] → Turnstile`
4. Click **Add widget**
5. Enter a name (e.g. `ACM Atlanta Registration`) and add your domain (`atlanta.acm.org`)
6. Choose **Managed** mode → click **Create**
7. Copy the **Site Key** and **Secret Key** from the confirmation screen  
   → You can always retrieve them later at `dash.cloudflare.com → [Your Account] → Turnstile → [Widget name] → Settings`

> If you ever need to rotate the keys (e.g. after a suspected compromise), create a new widget in Cloudflare, update both keys in WP Admin, then delete the old widget.

---

## Design System

All design tokens are defined in `css/variables.css`. Change a value there and it updates everywhere.

### Brand Colors

| Variable | Value | Usage |
|---|---|---|
| `--blue` | `#0062A3` | Primary blue, links, accents |
| `--blue-dark` | `#002855` | Dark navy, header text, footer bg |
| `--blue-light` | `#EEF5FB` | Light background sections |
| `--gold` | `#F7A800` | CTAs, highlights, eyebrows |
| `--gold-dark` | `#D4920A` | Gold hover state |

### Typography

| Variable | Value |
|---|---|
| `--font-serif` | Merriweather (headings) |
| `--font-sans` | Source Sans 3 (body) |

### Breakpoints (in responsive.css)

| Breakpoint | Width | Target |
|---|---|---|
| Desktop | > 960px | Default styles |
| Tablet | ≤ 960px | 2-column layouts |
| Mobile | ≤ 640px | Single column |
| Small Mobile | ≤ 480px | Hidden nav, hamburger menu |

---

## Credentials & Access

> ⚠️ **Never store credentials in Git.** Get these from the chapter chair.

| Service | URL | Notes |
|---|---|---|
| Live site | https://atlanta.acm.org | Public |
| WordPress Admin | https://atlanta.acm.org/wp-admin | WP credentials |
| cPanel | https://<YOUR-HOSTING-IP>:2083 | Hosting admin |
| FTP/SFTP Host | `<YOUR-HOSTING-IP>` | Port 21 (FTP) |
| FTP Username | `atlantahosting` | Same as cPanel |
| ACM Tech Support | technicalsupport@acm.org | For hosting issues |
| GitHub Repo | https://github.com/gsadaram144/atlantaacmchapter | Request access from chapter chair |

---

## Troubleshooting

### Theme shows "Stylesheet is missing" in WordPress

The `style.css` file is missing or empty. Open `style.css` and make sure it starts with:

```css
/*
Theme Name: ACM Atlanta
...
*/
```

### SFTP upload fails with "Permission denied"

The remote folder doesn't exist. Go to cPanel File Manager and manually create:
```
public_html/wp-content/themes/acm-atlanta/
```

### SFTP upload fails with "Login authentication failed"

Your credentials in `sftp.json` are wrong. Double-check `username` and `password` with the chapter chair.

### Cannot access atlanta.hosting.acm.org

This hostname does not resolve via public DNS. Use the IP address `<YOUR-HOSTING-IP>` directly for cPanel and SFTP access.

### Local site not loading at acm-atlanta.local

1. Open **Local by Flywheel**
2. Make sure the `acm-atlanta` site shows **"Running"** status (green)
3. If stopped, click the **Start** button
4. Try flushing DNS: `sudo dscacheutil -flushcache; sudo killall -HUP mDNSResponder`

### Images not showing locally

Logo and banner images reference production URLs (`atlanta.acm.org/wp-content/uploads/...`). They will only show locally if you have internet access and the production server is up. This is expected behavior — images always display correctly on the live site.

### Git push fails with authentication error

GitHub no longer accepts passwords. Set up SSH authentication:
```bash
ssh-keygen -t ed25519 -C "your@email.com"
cat ~/.ssh/id_ed25519.pub
```
Copy the output and add it to **GitHub → Settings → SSH and GPG keys → New SSH key**. Then:
```bash
git remote set-url origin git@github.com:gsadaram144/atlantaacmchapter.git
```

---

## Contributing

We welcome contributions from all chapter members! Before making changes, please read [CONTRIBUTING.md](CONTRIBUTING.md) which covers:

- How to create a branch and submit a Pull Request
- Branch naming conventions
- Commit message format
- What types of changes are welcome
- The review and merge process

> **The short version:** never commit to `main` directly. Always create a branch, make your changes, and open a PR on GitHub for review.

---

## Need Help?

- **Hosting issues:** Email `technicalsupport@acm.org`
- **Site/code issues:** Open an issue on [GitHub](https://github.com/gsadaram144/atlantaacmchapter/issues)
- **General questions:** Contact the chapter chair