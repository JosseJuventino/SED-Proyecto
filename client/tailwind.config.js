module.exports = {
  content: [
    "./public/**/*.html",
    "./*.php",
    "./app/**/*.{html,js,php}",
    "./components/**/*.{html,js,php}",
  ],
  theme: {
    extend: {
      colors: {
        background: "#0a0b0f",
        foreground: "#ffffff",
        primary: "#1a1d24",
        secondary: "#2a2f3a",
        accent: "#3f4756",
        success: "#10b981",
      },
    },
  },
  plugins: [],
};
