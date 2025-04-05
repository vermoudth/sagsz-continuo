document.addEventListener("DOMContentLoaded", function () {
  const htmlElement = document.documentElement;
  const toggleBtn = document.getElementById("darkModeToggle");
  const icon = document.getElementById("themeIcon");

  function applyTheme(theme) {
    htmlElement.setAttribute("data-bs-theme", theme);
    localStorage.setItem("theme", theme);
    icon.textContent = theme === "dark" ? "☀️" : "🌙";
  }

  // Inicializar tema desde localStorage
  const savedTheme = localStorage.getItem("theme") || "light";
  applyTheme(savedTheme);

  toggleBtn.addEventListener("click", function () {
    const currentTheme = htmlElement.getAttribute("data-bs-theme");
    const newTheme = currentTheme === "dark" ? "light" : "dark";
    applyTheme(newTheme);
  });
});