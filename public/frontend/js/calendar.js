// script.js

/**
 * Initializes the calendar with given settings.
 *
 * @param {Object} settings - Configuration settings for the calendar.
 * @param {string} settings.disabledDatesUrl - URL to fetch disabled dates from the server.
 * @param {Array<number>} settings.disabledWeekdays - Array of weekdays to disable (0 = Sunday, 6 = Saturday).
 * @param {Object} settings.weekdayComments - Comments for disabled weekdays.
 * @param {Array<string>} settings.disabledDates - Array of days to disable.
 * @param {Object} settings.disabledDateComments - Comments for specific disabled dates.
 * @param {string} settings.inputId - ID of the input field to display the selected date.
 */
function initializeCalendar(settings) {
  const calendar = document.getElementById("calendar");
  const currentMonthYear = document.getElementById("current-month-year");
  const prevMonthButton = document.getElementById("prev-month");
  const nextMonthButton = document.getElementById("next-month");
  const selectedDateInput = document.getElementById(settings.inputId);

  let currentYear = new Date().getFullYear();
  let currentMonth = new Date().getMonth();

  let disabledDates = settings.disabledDates || []; // Initialize as empty
  const disabledWeekdays = settings.disabledWeekdays || [];
  const weekdayComments = settings.weekdayComments || {};
  const disabledDateComments = settings.disabledDateComments || {};

  /**
   * Get today date in format
   */
  // Function to format today's date as YYYY-MM-DD
  function getTodayFormattedDate() {
    const today = new Date();
    const year = today.getFullYear();
    const month = today.getMonth(); // getMonth() is zero-based
    const day = today.getDate();
    return `${year}-${String(month + 1).padStart(2, "0")}-${String(
      day
    ).padStart(2, "0")}`;
  }

  /**
   * Fetches disabled dates from the server.
   */
  function fetchDisabledDates() {
    return fetch(settings.disabledDatesUrl)
      .then((response) => response.json())
      .then((data) => {
        disabledDates = data;
        updateCalendar();
      })
      .catch((error) => {
        console.error("Error fetching disabled dates:", error);
        // Initialize with an empty object or some fallback
        disabledDates = {};
        updateCalendar();
      });
  }

  /**
   * Creates and displays the calendar for the given year and month.
   *
   * @param {number} year - The year to display.
   * @param {number} month - The month to display.
   */
  function createCalendar(year, month) {
    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();
    const table = document.createElement("table");
    let day = 1;

    // Create table header
    const header = document.createElement("tr");
    ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"].forEach((dayName) => {
      const th = document.createElement("th");
      th.textContent = dayName;
      header.appendChild(th);
    });
    table.appendChild(header);

    // Create table rows
    for (let i = 0; i < 5; i++) {
      const row = document.createElement("tr");
      for (let j = 0; j < 7; j++) {
        const cell = document.createElement("td");
        const cellDiv = document.createElement("div");
        cell.appendChild(cellDiv); // Add div inside td
        const currentDate = new Date(year, month, day);

        if ((i === 0 && j < firstDay) || day > lastDate) {
          cell.innerText = "";
        } else {
          const formattedDate = `${year}-${String(month + 1).padStart(
            2,
            "0"
          )}-${String(day).padStart(2, "0")}`;
          cellDiv.innerText = day;

          if (formattedDate == getTodayFormattedDate()) {
            cell.classList.add("selected-date");
            handleDateSelect(cell, formattedDate);
          } else if (disabledWeekdays.includes(j)) {
            cell.classList.add("disabled-weekday");
            if (weekdayComments[j]) {
              const tooltip = document.createElement("div");
              tooltip.classList.add("tooltip");
              tooltip.textContent = weekdayComments[j];
              cell.appendChild(tooltip);
            }
          } else if (disabledDates.includes(formattedDate)) {
            cell.classList.add("disabled");
            const tooltip = document.createElement("div");
            tooltip.classList.add("tooltip");
            tooltip.textContent =
              disabledDateComments[formattedDate] || "This date is disabled.";
            cell.appendChild(tooltip);
          } else {
            cell.classList.add("available");
            handleDateSelect(cell, formattedDate);
          }
          day++;
        }
        row.appendChild(cell);
      }
      table.appendChild(row);
    }
    calendar.innerHTML = "";
    calendar.appendChild(table);

    // Update month/year display
    currentMonthYear.textContent = `${new Date(year, month).toLocaleString(
      "default",
      { month: "long" }
    )} ${year}`;
  }

  /**
   * Handle Click on Select Date
  */
  function handleDateSelect(cell, formattedDate){
    cell.addEventListener("click", () => {
      const allAvailableDates = document.querySelectorAll("td.selected-date");
      allAvailableDates.forEach((element) => {
        element.classList.remove("selected-date");
        element.classList.add("available");
      });
      cell.classList.remove("available");
      cell.classList.add("selected-date");

      selectedDateInput.value = formattedDate; // Update input field with selected date
      // Trigger change event to initialize the time options
      selectedDateInput.dispatchEvent(new Event("change"));
    });
  }

  /**
   * Updates the calendar by re-rendering it.
   */
  function updateCalendar() {
    createCalendar(currentYear, currentMonth);
  }

  // Event listeners for navigation buttons
  prevMonthButton.addEventListener("click", () => {
    if (currentMonth === 0) {
      currentMonth = 11;
      currentYear--;
    } else {
      currentMonth--;
    }
    updateCalendar();
  });

  nextMonthButton.addEventListener("click", () => {
    if (currentMonth === 11) {
      currentMonth = 0;
      currentYear++;
    } else {
      currentMonth++;
    }
    updateCalendar();
  });

  // Initialize calendar by fetching disabled dates and then rendering
  //fetchDisabledDates();

  // Initialize calendar
  updateCalendar();
}
