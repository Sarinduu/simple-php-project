function handleStatusChange() {
  const selected = document.getElementById("entry_type_select").value;
  const endTimeGroup = document.getElementById("end_time_group");
  if (selected === "Login" || selected === "Logout") {
    endTimeGroup.style.display = "none";
  } else {
    endTimeGroup.style.display = "block";
  }
}

const modal = document.getElementById("addModal");
const form = document.getElementById("attendanceForm");

function closeModal() {
  modal.style.display = "none";
  form.reset();
  document.getElementById("end_time_group").style.display = "block";
}

window.onclick = function (event) {
  if (event.target === modal) {
    closeModal();
  }
};

document.querySelector(".close-btn").addEventListener("click", closeModal);
