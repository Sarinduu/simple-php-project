function toggleDropdown() {
  const dropdown = document.getElementById("logoutDropdown");
  dropdown.classList.toggle("show");
}

window.onclick = function(event) {
  if (!event.target.matches('.user-icon')) {
    const dropdowns = document.getElementsByClassName("dropdown-content");
    for (let i = 0; i < dropdowns.length; i++) {
      dropdowns[i].classList.remove('show');
    }
  }
}