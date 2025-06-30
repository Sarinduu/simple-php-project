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
const modal2 = document.getElementById("editModal");
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

function closeModal2() {
  modal2.style.display = "none";
}

window.onclick = function (event) {
  if (event.target === modal2) {
    closeModal2();
  }
};

document.querySelector(".close-btn").addEventListener("click", closeModal);

function openEditModal(id, type, startTime, endTime) {
  const extractTime = (dt) =>
    dt ? new Date(dt).toTimeString().slice(0, 5) : "";

  document.getElementById("edit_entry_id").value = id;
  document.getElementById("edit_entry_type").value = type;
  document.getElementById("edit_start_time").value = extractTime(startTime);
  document.getElementById("edit_end_time").value = extractTime(endTime);
  document.getElementById("editModal").style.display = "flex";
}
