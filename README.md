# Grid for Drupal

The Drupal integration of the [grid library](https://github.com/palasthotel/grid): editors
compose landing pages from containers and boxes in the grid editor and publish them as
drafts and revisions. Boxes show nodes, blocks, images, galleries, videos, HTML, RSS feeds
and lists; videos and other embeds can ask for consent first (two-click).

Requires Drupal 10.3 or 11 and PHP 8.2.

## Installation

The module and the grid library are installed with Composer from GitHub. Add both
repositories to the project's `composer.json`:

```json
"repositories": [
    { "type": "vcs", "url": "https://github.com/palasthotel/drupal-grid" },
    { "type": "vcs", "url": "https://github.com/palasthotel/grid" }
]
```

and require the module:

```sh
composer require palasthotel/drupal-grid
```

The module goes to `modules/contrib/grid`. The grid library has the package type
`drupal-library` and goes to the libraries directory, with the installer path Drupal
projects usually have:

```json
"installer-paths": {
    "web/libraries/{$name}": ["type:drupal-library"]
}
```

The library ships the sources of its editor, not the built bundle. Build it there, as part
of the project's build or deploy:

```sh
(cd web/libraries/grid && npm ci && npm run build)
```

If the project commits its contrib code, commit `libraries/grid/js/dist` with it. The
status report (`/admin/reports/status`, "Grid library") tells whether the library is
installed and built.

Then enable the module and set it up:

```sh
drush pm:install grid
```

- **Grid → Settings** (`/admin/config/grid/settings`): the content types that get a grid,
  the container placed on empty grids, default container, slot and box styles, the
  content type used for sidebars and the view modes node boxes may use.
- **Permissions:** "administer grid" lets a role use the grid editor, the reusable boxes
  and containers, the Container Factory and the styles.
- **Grid → Settings Two Click** (`/admin/config/grid/settings-two-click`): two-click
  consent for all video and HTML boxes - YouTube, Vimeo, Spotify and Flickr albums show a
  preview with a disclaimer until the visitor agrees -, the disclaimer text, the link to
  the privacy policy and the Vimeo API key for thumbnails.

A content type with a grid gets a "The Grid" tab next to "Edit".

## Updating from 2.x or from a copy of the module

Until 3.0 the module brought the grid library as the Git submodule `_grid`, and some
projects keep a copy of the module, with the library, in their repository.

1. **Back up the database.** The update deletes duplicate links between grids, containers,
   slots and boxes (see the grid library's
   [upgrade notes](https://github.com/palasthotel/grid#upgrading-to-30)).
2. Remove the copy of the module (`modules/contrib/grid`, including `_grid`).
3. Install with Composer and build the editor as described above.
4. Run the database updates: `drush updatedb`. `grid_update_91002` runs the library's
   schema updates.
5. Check custom code against the library's upgrade notes: `Editor` takes the `iHook` as
   third argument, custom boxes that bring their own SimplePie use the library's instead.

Sites whose grid module is older than update 8104 (8.x-1.x) update to a 2.x release first.

## Development

Pull requests are checked with `php -l` on PHP 8.2 to 8.4 and `composer validate`. See
[CONTRIBUTING.md](CONTRIBUTING.md) for commit messages and releases and
[SECURITY.md](SECURITY.md) for reporting vulnerabilities. Changes are listed in
[CHANGELOG.md](CHANGELOG.md).

## License

GPL-3.0-or-later, see [LICENSE](LICENSE).
