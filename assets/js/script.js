document.querySelectorAll(".toggle-status").forEach(link => {
  link.addEventListener("click", async (e) => {
    e.preventDefault();
    const response = await fetch(link.href);
    const data = await response.json();

    if(data.success) {
      link.textContent = data.status;
      link.classList.remove("status-active", "status-completed");

      if(data.status === "completed") {
        link.classList.add("status-completed");
      } else {
        link.classList.add("status-active");
      }
    }
  });
});
