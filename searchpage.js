// Sample pet data
const pets = [
  {
    id: 1,
    name: "Buddy",
    type: "dog",
    breed: "Golden Retriever",
    age: "2 years",
    location: "New York Shelter",
    image:
      "https://images.unsplash.com/photo-1552053831-71594a27632d?w=300&h=200&fit=crop",
  },
  {
    id: 2,
    name: "Luna",
    type: "cat",
    breed: "Siamese",
    age: "1 year",
    location: "LA Rescue Center",
    image:
      "https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=300&h=200&fit=crop",
  },
  {
    id: 3,
    name: "Max",
    type: "dog",
    breed: "German Shepherd",
    age: "3 years",
    location: "Chicago Shelter",
    image:
      "https://images.unsplash.com/photo-1560743641-3914f2c45636?w=300&h=200&fit=crop",
  },
  {
    id: 4,
    name: "Bella",
    type: "cat",
    breed: "Maine Coon",
    age: "4 years",
    location: "Miami Rescue",
    image:
      "https://images.unsplash.com/photo-1533738363-b7f9aef128ce?w=300&h=200&fit=crop",
  },
  {
    id: 5,
    name: "Coco",
    type: "rabbit",
    breed: "Holland Lop",
    age: "6 months",
    location: "Boston Shelter",
    image:
      "https://images.unsplash.com/photo-1585110396000-c9ffd4e4b308?w=300&h=200&fit=crop",
  },
  {
    id: 6,
    name: "Charlie",
    type: "bird",
    breed: "Parakeet",
    age: "1 year",
    location: "Seattle Rescue",
    image:
      "https://images.unsplash.com/photo-1552728089-57bdde30beb3?w=300&h=200&fit=crop",
  },
  {
    id: 7,
    name: "Rocky",
    type: "dog",
    breed: "Bulldog",
    age: "5 years",
    location: "Dallas Shelter",
    image:
      "https://cdn.britannica.com/07/234207-050-0037B589/English-bulldog-dog.jpg",
  },
  {
    id: 8,
    name: "Misty",
    type: "cat",
    breed: "Persian",
    age: "2 years",
    location: "Denver Rescue",
    image:
      "https://images.unsplash.com/photo-1592194996308-7b43878e84a6?w=300&h=200&fit=crop",
  },
];

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
    // Redirect to application page or open modal
    window.location.href = "application.php";
  }
}

// Initialize the page when loaded
document.addEventListener("DOMContentLoaded", init);
