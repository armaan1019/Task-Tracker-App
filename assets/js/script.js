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

const modal = document.getElementById("deleteModal");
const taskTitle = document.getElementById("taskTitle");
const confirmDelete = document.getElementById("confirmDelete");
const cancelDelete = document.getElementById("cancelDelete");

document.querySelectorAll(".open-delete-modal").forEach(button => {
  button.addEventListener("click", (e) => {
    e.preventDefault();

    const id = button.dataset.taskId;
    const title = button.dataset.taskTitle;

    taskTitle.textContent = title;

    confirmDelete.href = `delete_task.php?id=${id}`;
    modal.classList.add("show");
  });
});

cancelDelete.addEventListener("click", () => {
  modal.classList.remove("show");
});

modal.addEventListener("click", (e) => {
  if(e.target === modal) {
    modal.classList.remove("show");
  }
});
