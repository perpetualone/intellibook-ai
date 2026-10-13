# Homebrew formula for the Intellibook AI CLI

`Formula/intellibook.rb` installs the `intellibook-ai` npm package. It is not
ready to ship until the steps below are done.

1. Publish the CLI to npm (from `packages/cli`): `npm publish --access public`.
2. Compute the checksum of the published tarball and add it to the formula as
   `sha256 "<hash>"` directly below the `url` line (Homebrew requires it):

   ```bash
   curl -sL https://registry.npmjs.org/intellibook-ai/-/intellibook-ai-1.0.0.tgz | shasum -a 256
   ```

3. Homebrew installs formulae from a tap, which must be its own GitHub repo
   named `homebrew-<name>` (for example `perpetualone/homebrew-intellibook`).
   Copy `Formula/intellibook.rb` into that repo.
4. Users then run `brew install perpetualone/intellibook/intellibook`.

Update the `url` version and `sha256` whenever a new CLI version is published.
