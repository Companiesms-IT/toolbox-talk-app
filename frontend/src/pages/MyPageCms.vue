<template>
  <div id="app">
    <h2>Custom Multi-Select Fruits:</h2>

    <div class="custom-select-wrapper">
      <label for="custom-fruit-select">Select Fruits:</label>
      <div
        id="custom-fruit-select"
        class="selected-display"
        :class="{ 'is-open': dropdownOpen }"
        @click="toggleDropdown"
        tabindex="0"
        @keydown.enter.space.prevent="toggleDropdown"
        @keydown.esc="closeDropdown"
      >
        <span class="placeholder">
          Please select items
        </span>

        <span class="dropdown-arrow" :class="{ 'arrow-up': dropdownOpen }"></span>
      </div>

      <div v-if="dropdownOpen" class="options-dropdown">
        <ul>
          <li
            v-for="fruit in availableFruits"
            :key="fruit.id"
            @click="toggleFruitSelection(fruit.id)"
            :class="{ 'is-selected': isSelected(fruit.id) }"
          >
            {{ fruit.name }}
          </li>
        </ul>
      </div>
    </div>

    <div v-if="selectedFruits.length > 0" class="display-outside-pills">
      <h3>Selected Fruits:</h3>
      <div class="pills-wrapper-outside">
        <div v-for="fruitId in selectedFruits" :key="fruitId" class="selected-pill-outside">
          {{ getFruitNameById(fruitId) }}
          <button @click="removeFruit(fruitId)" class="remove-pill-btn">x</button>
        </div>
      </div>
    </div>

    <p v-else>No fruits selected yet.</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      availableFruits: [
        { id: 1, name: 'Apple' },
        { id: 2, name: 'Banana' },
        { id: 3, name: 'Cherry' },
        { id: 4, name: 'Date' },
        { id: 5, name: 'Elderberry' },
        { id: 6, name: 'Fig' },
        { id: 7, name: 'Grape' },
        { id: 8, name: 'Honeydew' },
      ],
      selectedFruits: [], // Stores IDs of selected fruits
      dropdownOpen: false,
    };
  },
  methods: {
    /**
     * Retrieves the name of a fruit given its ID.
     * @param {number} id - The ID of the fruit.
     * @returns {string} The name of the fruit, or 'Unknown Fruit' if not found.
     */
    getFruitNameById(id) {
      const fruit = this.availableFruits.find(f => f.id === id);
      return fruit ? fruit.name : 'Unknown Fruit';
    },

    /**
     * Checks if a fruit ID is currently in the selectedFruits array.
     * @param {number} id - The ID of the fruit to check.
     * @returns {boolean} True if selected, false otherwise.
     */
    isSelected(id) {
      return this.selectedFruits.includes(id);
    },

    /**
     * Toggles the selection of a fruit. If already selected, it deselects; otherwise, it selects.
     * @param {number} fruitId - The ID of the fruit to toggle.
     */
    toggleFruitSelection(fruitId) {
      if (this.isSelected(fruitId)) {
        this.selectedFruits = this.selectedFruits.filter(id => id !== fruitId);
      } else {
        this.selectedFruits.push(fruitId);
      }
    },

    /**
     * Removes a specific fruit from the selectedFruits array.
     * @param {number} fruitIdToRemove - The ID of the fruit to remove.
     */
    removeFruit(fruitIdToRemove) {
      this.selectedFruits = this.selectedFruits.filter(id => id !== fruitIdToRemove);
    },

    /** Toggles the open/closed state of the dropdown. */
    toggleDropdown() {
      this.dropdownOpen = !this.dropdownOpen;
    },

    /** Closes the dropdown. */
    closeDropdown() {
      this.dropdownOpen = false;
    },

    /**
     * Handles clicks outside the component to close the dropdown.
     * @param {Event} event - The click event.
     */
    handleClickOutside(event) {
      // Check if the click occurred outside the entire component's root element
      if (this.$el && !this.$el.contains(event.target)) {
        this.closeDropdown();
      }
    },
  },
  mounted() {
    // Add a global click listener when the component is mounted
    document.addEventListener('click', this.handleClickOutside);
  },
  beforeUnmount() {
    // Remove the global click listener before the component is unmounted to prevent memory leaks
    document.removeEventListener('click', this.handleClickOutside);
  },
};
</script>

<style scoped>
/* Base styling for the entire app container */
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  margin-top: 60px;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
  padding: 20px;
  border: 1px solid #eee;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Wrapper for the custom select component to position dropdown correctly */
.custom-select-wrapper {
  position: relative;
  margin-bottom: 20px;
  width: 100%;
}

/* Styling for the label associated with the custom select */
label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

/* The visible 'input' area of the custom select */
.selected-display {
  display: flex;
  align-items: center;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px 12px;
  min-height: 40px; /* Ensures consistent height */
  cursor: pointer;
  background-color: white;
  position: relative;
  box-sizing: border-box; /* Include padding and border in the element's total size */
  transition: border-color 0.2s, box-shadow 0.2s;
}

/* Focus and open states for the selected-display */
.selected-display:focus {
  outline: none;
  border-color: #42b983;
  box-shadow: 0 0 0 2px rgba(66, 185, 131, 0.2);
}

.selected-display.is-open {
  border-color: #42b983;
  box-shadow: 0 0 0 2px rgba(66, 185, 131, 0.2);
  border-bottom-left-radius: 0; /* No border radius at the bottom corners when open */
  border-bottom-right-radius: 0;
}

/* Placeholder text (now always visible) */
.placeholder {
  color: #888;
  flex-grow: 1; /* Pushes the dropdown arrow to the right */
  background: none;
}

/* Dropdown arrow icon */
.dropdown-arrow {
  margin-left: auto; /* Pushes arrow to the far right */
  width: 0;
  height: 0;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-top: 5px solid #555; /* Downward-pointing triangle */
  transition: transform 0.2s ease; /* Smooth rotation */
}

/* Rotate arrow when dropdown is open */
.dropdown-arrow.arrow-up {
  transform: rotate(180deg);
}

/* Styling for the dropdown list itself */
.options-dropdown {
  position: absolute;
  width: 100%;
  border: 1px solid #42b983; /* Green border */
  border-top: none; /* No top border, connects to selected-display */
  border-radius: 0 0 4px 4px; /* Rounded bottom corners */
  background-color: white;
  z-index: 1000; /* Ensures dropdown appears above other content */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  max-height: 200px; /* Limits height and adds scrollbar if content overflows */
  overflow-y: auto;
  box-sizing: border-box;
}

.options-dropdown ul {
  list-style: none; /* Remove bullet points */
  padding: 0;
  margin: 0;
}

.options-dropdown li {
  padding: 10px 12px;
  cursor: pointer;
  transition: background-color 0.2s, color 0.2s;
}

.options-dropdown li:hover {
  background-color: #f0f0f0; /* Light gray on hover */
}

/* Style for selected items in the dropdown list */
.options-dropdown li.is-selected {
  background-color: #e6f7ff; /* Light blue */
  color: #0056b3; /* Darker blue text */
  font-weight: bold;
}

/* --- Styles for pills displayed outside the component --- */
.display-outside-pills {
  margin-top: 30px;
  border-top: 1px solid #eee;
  padding-top: 20px;
}

.pills-wrapper-outside {
  display: flex;
  flex-wrap: wrap;
  gap: 8px; /* Space between pills */
}

/* Individual pill styling when displayed outside */
.selected-pill-outside {
  display: inline-flex;
  align-items: center;
  background-color: #42b983; /* Theme green background */
  color: white;
  padding: 6px 10px;
  border-radius: 20px;
  font-size: 0.9em;
  white-space: nowrap;
}

/* General styling for the remove button on pills */
.remove-pill-btn {
  background: none;
  border: none;
  color: inherit; /* Inherit color from the parent pill */
  margin-left: 8px;
  cursor: pointer;
  font-weight: bold;
  font-size: 1em;
  padding: 0;
  line-height: 1; /* Aligns 'x' vertically */
  transition: opacity 0.2s;
}

.remove-pill-btn:hover {
  opacity: 0.8;
}
</style>