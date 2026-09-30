# Contributing to the ACM Atlanta Website

Thank you for helping maintain and improve the ACM Atlanta chapter website! This guide explains how to propose and submit changes using a **Pull Request (PR) workflow** — the same process used by professional software teams.

All changes, no matter how small, go through a PR so they can be reviewed before going live.

---

## Table of Contents

1. [Before You Start](#before-you-start)
2. [The Golden Rule](#the-golden-rule)
3. [Step-by-Step Contribution Workflow](#step-by-step-contribution-workflow)
4. [Branch Naming Convention](#branch-naming-convention)
5. [Writing Good Commit Messages](#writing-good-commit-messages)
6. [Opening a Pull Request](#opening-a-pull-request)
7. [The Review Process](#the-review-process)
8. [After Your PR is Merged](#after-your-pr-is-merged)
9. [Types of Contributions](#types-of-contributions)
10. [What Not to Change](#what-not-to-change)

---

## Before You Start

1. Make sure you have completed the full local development setup described in [README.md](README.md)
2. Confirm your local site is running at `http://acm-atlanta.local`
3. Make sure you have been granted access to the GitHub repository — contact the chapter chair if not

---

## The Golden Rule

> **Never commit directly to `main`.** The `main` branch always reflects what is live on [atlanta.acm.org](https://atlanta.acm.org). All changes must go through a Pull Request.

---

## Step-by-Step Contribution Workflow

### Step 1 — Always Start from an Updated main

Before creating a branch, make sure your local `main` is up to date:

```bash
cd ~/Local\ Sites/acm-atlanta/
git checkout main
git pull origin main
```

This ensures your work starts from the latest version of the site and avoids merge conflicts later.

---

### Step 2 — Create a New Branch

Create a branch named after what you're working on (see [Branch Naming Convention](#branch-naming-convention)):

```bash
git checkout -b your-branch-name
```

Example:

```bash
git checkout -b feature/about-page
```

You are now working on your own branch — `main` is untouched.

---

### Step 3 — Make Your Changes

Edit files in `app/public/wp-content/themes/acm-atlanta/` and preview at `http://acm-atlanta.local`.

Keep changes focused — one branch should do **one thing**. If you notice an unrelated bug while working, open a separate branch for it.

---

### Step 4 — Commit Your Changes

Stage and commit your work with a clear message:

```bash
git add .
git commit -m "feat: add About page template with officer bios section"
```

You can make multiple commits on your branch as you work — that's fine and encouraged. See [Writing Good Commit Messages](#writing-good-commit-messages) for guidelines.

---

### Step 5 — Push Your Branch to GitHub

```bash
git push origin your-branch-name
```

Example:

```bash
git push origin feature/about-page
```

---

### Step 6 — Open a Pull Request

1. Go to [https://github.com/gsadaram144/atlantaacmchapter](https://github.com/gsadaram144/atlantaacmchapter)
2. GitHub will show a yellow banner: **"Compare & pull request"** — click it
3. If you don't see the banner, click **"Pull requests"** → **"New pull request"**
4. Set:
   - **Base branch:** `main`
   - **Compare branch:** your branch
5. Fill in the PR form (see [Opening a Pull Request](#opening-a-pull-request))
6. Click **"Create pull request"**

---

### Step 7 — Address Review Feedback

A reviewer may request changes. To update your PR:

```bash
# Make the requested edits in VS Code
git add .
git commit -m "fix: address review feedback on About page layout"
git push origin your-branch-name
```

The PR updates automatically — no need to open a new one.

---

### Step 8 — PR Gets Merged

Once approved, the chapter chair or maintainer merges your PR into `main` and deploys to production. You'll get a notification when it's merged.

---

## Branch Naming Convention

Use lowercase with hyphens. Prefix the branch name with the type of change:

| Prefix | Use for | Example |
|---|---|---|
| `feature/` | New pages or functionality | `feature/events-page` |
| `fix/` | Bug fixes | `fix/mobile-menu-overlap` |
| `update/` | Content updates | `update/officer-bios-2025` |
| `style/` | Visual/CSS changes | `style/footer-social-icons` |
| `chore/` | Maintenance, README, config | `chore/update-readme` |

**Good branch names:**
```
feature/about-page
fix/hero-image-not-loading
update/spring-2025-events
style/button-hover-animation
```

**Bad branch names:**
```
my-changes
test
johns-branch
fix
```

---

## Writing Good Commit Messages

Use the format: `type: short description of what changed`

| Type | Use when |
|---|---|
| `feat` | Adding something new |
| `fix` | Fixing a bug |
| `style` | CSS/visual changes only |
| `update` | Updating existing content |
| `chore` | Config, README, tooling |
| `refactor` | Restructuring code without changing behavior |

**Good commit messages:**
```
feat: add Officers page template with grid layout
fix: correct mobile nav z-index overlapping hero
style: increase footer link contrast for accessibility
update: replace placeholder events with March 2025 lineup
chore: add sql/ to .gitignore
```

**Bad commit messages:**
```
update
fixed stuff
changes
wip
asdf
```

---

## Opening a Pull Request

When creating a PR on GitHub, fill in the description using this template:

```
## What does this PR do?
A clear, one or two sentence summary of the change.

## Type of change
- [ ] New feature (new page, new section)
- [ ] Bug fix
- [ ] Content update
- [ ] Style / visual change
- [ ] Maintenance / chore

## How to review
Steps to preview the change locally, e.g.:
1. Pull the branch: `git checkout feature/about-page`
2. Visit http://acm-atlanta.local/about/

## Screenshots (if applicable)
Paste before/after screenshots for visual changes.

## Checklist
- [ ] I tested this locally at http://acm-atlanta.local
- [ ] I checked on mobile (resize browser to 375px width)
- [ ] I have not committed any credentials or passwords
- [ ] My branch is up to date with main
```

---

## The Review Process

- All PRs require **at least one approval** from a maintainer before merging
- The reviewer will check for: visual correctness, code quality, mobile responsiveness, and no broken links
- Expect feedback within **3–5 business days**
- If your PR sits without review for more than a week, ping the chapter chair

### Reviewers

| Role | Responsibility |
|---|---|
| Chapter Chair | Final approval and deployment |
| Maintainer | Code review and feedback |

---

## After Your PR is Merged

1. Delete your branch — it's no longer needed:

```bash
git checkout main
git pull origin main
git branch -d your-branch-name
```

2. GitHub also offers a **"Delete branch"** button directly on the merged PR page.

---

## Types of Contributions

### ✅ Welcome contributions

- New slug-based page templates (create `page-yourslug.php` in theme root)
- Event and officer content updates
- Bug fixes for layout or styling issues
- Accessibility improvements
- Mobile responsiveness fixes
- Documentation improvements

### ⚠️ Discuss first (open a GitHub Issue before starting)

- Restructuring the CSS architecture
- Changing brand colors or typography
- Adding new third-party dependencies or plugins
- Significant homepage redesigns

### ❌ Not accepted via PR

- Changes to WordPress core files
- Changes to `conf/` or `logs/` (Local by Flywheel internals)
- Committing `.vscode/sftp.json` or any credentials
- Database files (`app/sql/`)

---

## What Not to Change

These files and folders are excluded from version control for good reason — do not attempt to commit them:

| Path | Why |
|---|---|
| `.vscode/sftp.json` | Contains server credentials |
| `app/sql/` | Local database dump with environment-specific data |
| `app/public/wp-admin/` | WordPress core — not our code |
| `app/public/wp-includes/` | WordPress core — not our code |
| `app/public/wp-content/uploads/` | Media files managed via WordPress Admin |
| `conf/` | Local by Flywheel server config |
| `logs/` | Local by Flywheel logs |

---

## Questions?

- **General questions:** Contact the chapter chair
- **Bug reports:** [Open a GitHub Issue](https://github.com/gsadaram144/atlantaacmchapter/issues)
- **Hosting / server issues:** Email `technicalsupport@acm.org`