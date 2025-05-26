function init() {
  const listContainer = document.getElementById("list-items");
  listContainer.addEventListener("click", (event) => {
    const arrow = event.target.closest("[data-open]");
    if (arrow) {
      const parent = arrow.closest("[data-parent]");
      parent.classList.toggle("list-item_open");
    }
  });
}

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", init);
} else {
  init();
}
