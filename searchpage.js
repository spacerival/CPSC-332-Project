// DOM elements
const petsGrid = document.getElementById("petsGrid");
const searchInput = document.getElementById("searchInput");
const filterButtons = document.querySelectorAll(".filter-btn");

let currentFilter = "all";
let currentSearch = "";

// Initialize the page
function init() {
  displayPets(pets);
  setupEventListeners();
}

// Display pets in the grid
function displayPets(petsToDisplay) {
  if (petsToDisplay.length === 0) {
    petsGrid.innerHTML =
      '<div class="no-results">No pets found matching your criteria.</div>';
    return;
  }

  petsGrid.innerHTML = petsToDisplay
    .map(
      (pet) => `
        <div class="pet-card" data-type="${pet.type}">
            <img src="${pet.image}" alt="${pet.name}" class="pet-image">
            <div class="pet-name">${pet.name}</div>
            <div class="pet-breed">${pet.breed}</div>
            <div class="pet-age">${pet.age}</div>
            <div class="pet-location">${pet.location}</div>
            <button class="adopt-btn" onclick="adoptPet(${pet.id})">Adopt ${pet.name}</button>
        </div>
    `
    )
    .join("");
}

// Filter and search pets
function filterPets() {
  let filteredPets = pets;

  // Apply type filter
  if (currentFilter !== "all") {
    filteredPets = filteredPets.filter((pet) => pet.type === currentFilter);
  }

  // Apply search filter
  if (currentSearch) {
    const searchTerm = currentSearch.toLowerCase();
    filteredPets = filteredPets.filter(
      (pet) =>
        pet.name.toLowerCase().includes(searchTerm) ||
        pet.breed.toLowerCase().includes(searchTerm) ||
        pet.type.toLowerCase().includes(searchTerm)
    );
  }

  displayPets(filteredPets);
}

// Setup event listeners
function setupEventListeners() {
  // Search input
  searchInput.addEventListener("input", (e) => {
    currentSearch = e.target.value;
    filterPets();
  });

  // Filter buttons
  filterButtons.forEach((button) => {
    button.addEventListener("click", () => {
      // Remove active class from all buttons
      filterButtons.forEach((btn) => btn.classList.remove("active"));
      // Add active class to clicked button
      button.classList.add("active");
      // Update current filter
      currentFilter = button.dataset.filter;
      filterPets();
    });
  });
}

// Adopt pet function
function adoptPet(petId) {
  const pet = pets.find((p) => p.id === petId);
  if (pet) {
    alert(
      `Thank you for your interest in adopting ${pet.name}! Please complete the adoption application form.`
    );
    // Redirect to application page
    window.location.href = "application.php?pet_id=" + petId;
  }
}

// Initialize the page when loaded
document.addEventListener("DOMContentLoaded", init);
