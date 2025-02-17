function openModal(modal) {
  modal.classList.add("is-visible");
}

function setupModalEvents(modal, closeButton) {
  closeButton.addEventListener("click", () => {
    modal.classList.remove("is-visible");
  });

  window.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.classList.remove("is-visible");
    }
  });

  window.addEventListener("keydown", (e) => {
    if (e.key === "Escape" || e.key === "Esc") {
      modal.classList.remove("is-visible");
    }
  });
}
