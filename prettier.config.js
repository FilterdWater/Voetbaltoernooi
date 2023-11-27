/** @type {import("prettier").config} */
const config = {
  tailwindConfig: './tailwind.config.js',
  plugins: ['@prettier/plugin-php', 'prettier-plugin-tailwindcss'],
  trailingComma: 'es5',
  tabWidth: 2,
  singleQuote: true,
  printWidth: 500,
  bracketSameLine: true,
  phpVersion: '7.4',
  overrides: [
    {
      files: ['*.php', '*.html'],
      options: {
        parser: 'php',
        embeddedLanguageFormatting: 'auto',
      },
    },
  ],
};
module.exports = config;
