class Intellibook < Formula
  desc "Official CLI for Intellibook AI — Autonomous WhatsApp AI Receptionist"
  homepage "https://www.intellibookai.com"
  url "https://registry.npmjs.org/intellibook-ai/-/intellibook-ai-1.0.0.tgz"
  license "MIT"

  depends_on "node"

  def install
    system "npm", "install", *Language::Node.std_npm_install_args(libexec)
    bin.install_symlink Dir["#{libexec}/bin/*"]
  end

  test do
    assert_match "Intellibook AI CLI", shell_output("#{bin}/intellibook help")
  end
end
