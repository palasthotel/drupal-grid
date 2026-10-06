# Contributing

## Branching

`main` is the default branch. Work on a feature branch and open a pull request against
`main`; the pull request check (PHP lint on 8.2 to 8.4, package metadata) has to pass.

## Commit messages

Releases and the changelog are generated from the commit history by
[release-please](https://github.com/googleapis/release-please), so commit messages follow
[Conventional Commits](https://www.conventionalcommits.org/):

| Type | Effect on the version | Appears in changelog |
|---|---|---|
| `fix:` | patch (3.0.0 → 3.0.1) | yes, "Bug Fixes" |
| `feat:` | minor (3.0.0 → 3.1.0) | yes, "Features" |
| `perf:` | patch | yes, "Performance Improvements" |
| `!` after the type, or a `BREAKING CHANGE:` footer | major (3.0.0 → 4.0.0) | yes, highlighted |
| `docs:`, `refactor:`, `chore:`, `test:`, `ci:`, `build:` | none | no |

Merge pull requests with a merge commit or by rebasing, so every commit reaches the
changelog. When squash-merging, the squash commit message itself has to be a conventional
commit - that is the message release-please reads.

### Who the changelog is for

`fix:` and `feat:` are for changes that sites notice: behaviour, boxes, settings,
permissions, hooks, templates, the editor. Workflows and repository documentation release
nothing.

Anything a site has to adapt to is a major: removed or renamed boxes, hooks, templates,
settings or routes, higher requirements. Mark it with `!` and say in the
`BREAKING CHANGE:` footer what sites have to do.

## Versions

Never edit version numbers by hand. `version.txt`, `CHANGELOG.md` and the `version:` line
of `grid.info.yml` are maintained by release-please.

## Releases

Merging the release pull request that release-please keeps open tags the version and
creates the GitHub release. There is no deploy: sites get the new tag through Composer.
