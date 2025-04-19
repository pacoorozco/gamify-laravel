#!/usr/bin/env bash
##
# Gamify - Gamification platform to implement any serious game mechanic.
#
# Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# Some rights reserved. See LICENSE and AUTHORS files.
#
# @author             Paco Orozco <paco@pacoorozco.info>
# @copyright          2018 Paco Orozco
# @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
#
# @link               https://github.com/pacoorozco/gamify-laravel
#

# ----------------------------------------------------------------------
# DO NOT MODIFY BEYOND THIS LINE
# ----------------------------------------------------------------------
# Program name and version
PN=$(basename "$0")
VER='0.5'
# Root directory where files reside in
ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"

# ----------------------------------------------------------------------
# Functions
# ----------------------------------------------------------------------
usage() {
  cat <<-EndUsage
	Bump the version of Gamify!
	version ${VER}

	usage: ${PN} [-h|--help] part

    Arguments:

    part (required)

    The part of the version to increase, e.g. minor.

    Given a version number MAJOR.MINOR.PATCH, increment the:

    MAJOR version when you make incompatible API changes,
    MINOR version when you add functionality in a backwards-compatible manner, and
    PATCH version when you make backwards-compatible bug fixes.

    The new VERSION will be updated in two files:

	    config/app.php
	    CHANGELOG.md

    Options:

    -h, --help   Prints usage and help.

	EndUsage
}

print_finish_release_note() {
  #
  # Get the current branch name
  #
  local _current_branch
  _current_branch=$(git rev-parse --abbrev-ref HEAD)

  #
  # Get last commit messages
  #
  local _last_commits
  _last_commits=$(git log "v${current_version}..HEAD" --pretty=format:'* %B' --no-merges --reverse | grep -v "Signed-off-by" | cat)

  cat <<-EndFinishReleaseNote
    Remember to:

        1. Update CHANGELOG.md

        ${_last_commits}

        2. Commit changes:

        $ git commit -s -m "Bump version ${current_version} -> ${new_version}" config/app.php CHANGELOG.md

        3. Tag the tree:

        $ git tag -s -m "Version ${new_version}" v${new_version}
        $ git push origin ${_current_branch} --tags

        4. Go to GitHub, create a PR and merge to the master branch:

        5. Update any development branch:

        $ git checkout ${_current_branch}
        $ git merge --no-ff ${_current_branch}
	EndFinishReleaseNote
}

get_new_version_number() {
  #
  # Set new version
  #
  case $1 in
  major) new_version=$(echo "${current_version}" | awk -F. '{ printf ("%d.%d.%d\n", $1 + 1, 0, 0); }') ;;
  minor) new_version=$(echo "${current_version}" | awk -F. '{ printf ("%d.%d.%d\n", $1, $2 + 1, 0); }') ;;
  patch) new_version=$(echo "${current_version}" | awk -F. '{ printf ("%d.%d.%d\n", $1, $2, $3 + 1); }') ;;
  esac
}

get_current_version_number() {
  #
  # Get current version from config/app.php
  #
  current_version=$(grep "'version' => '\(.*\)'" "${ROOT_DIR}/config/app.php" |
    head -1 |
    awk '{ print $3 }' | sed "s/[',]//g")
}

bump_version() {
  #
  # Format the current date for the README header
  #
  local _date
  _date=$(date '+%Y-%m-%d')

  echo -e "Bump version: ${current_version} -> ${new_version}\n"

  # Update version number on config/app.php
  sed -i "${ROOT_DIR}/config/app.php" -e "s/'version' => '\(.*\)'/'version' => '${new_version}'/g"

  # Create a new section on CHANGELOG
  sed -i "${ROOT_DIR}/CHANGELOG.md" -e "s/^## Unreleased/## Unreleased\n\n## ${new_version} - ${_date}\n/g"
}

# ----------------------------------------------------------------------
# Main
# ----------------------------------------------------------------------

get_current_version_number

if [[ -z "${current_version}" ]]; then
  echo "ERROR: Can't determine the current version."
  exit 1
fi

case $1 in
-h | --help)
  usage
  ;;
major | minor | patch)
  if [[ -n "$(git status -s -uno)" ]]; then
    echo 'ERROR: Uncommitted changes in repository. Commit before bump version' 1>&2
    exit 1
  fi
  get_new_version_number "$1"
  bump_version
  print_finish_release_note
  ;;
*)
  echo "ERROR: You have failed to specify what to do correctly. Use '${PN} --help' for more information."
  exit 1
  ;;
esac

exit 0
