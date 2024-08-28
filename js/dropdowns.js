// // Get all the dropdown from document
// document.querySelectorAll(".dropdown-toggle").forEach(dropDownFunc);

// // Dropdown Open and Close function
// function dropDownFunc(dropDown) {
//   if (dropDown.classList.contains("click-dropdown") === true) {
//     dropDown.addEventListener("click", function (e) {
//       e.preventDefault();

//       if (
//         this.nextElementSibling.classList.contains("dropdown-active") === true
//       ) {
//         // Close the clicked dropdown
//         this.parentElement.classList.remove("dropdown-open");
//         this.nextElementSibling.classList.remove("dropdown-active");
//       } else {
//         // Close the opened dropdown
//         closeDropdown();

//         // add the open and active class (Opening the DropDown)
//         this.parentElement.classList.add("dropdown-open");
//         this.nextElementSibling.classList.add("dropdown-active");
//       }
//     });
//   }

//   if (dropDown.classList.contains("hover-dropdown") === true) {
//     dropDown.onmouseover = dropdownHover;
//     dropDown.onmouseout = dropdownHover;

//     function dropdownHover(e) {
//       if (e.type === "mouseover") {
//         // Close the opened dropdowns
//         closeDropdown();

//         // add the open and active class (Opening the DropDown)
//         this.parentElement.classList.add("dropdown-open");
//         this.nextElementSibling.classList.add("dropdown-active");
//       }

//       if (e.type === "mouseout") {
//         // close the dropdown after user leaves the list
//         const self = this;
//         this.nextElementSibling.onmouseleave = function () {
//           self.parentElement.classList.remove("dropdown-open");
//           self.nextElementSibling.classList.remove("dropdown-active");
//         };
//       }
//     }
//   }
// }

// // Listen to the doc click
// window.addEventListener("click", function (e) {
//   // Close the menu if click happen outside menu
//   if (e.target.closest(".dropdown-container") === null) {
//     // Close the opened dropdown
//     closeDropdown();
//   }
// });

// // Close the opened Dropdowns
// function closeDropdown() {
//   // remove the open and active class from other opened Dropdown (Closing the opened DropDown)
//   document
//     .querySelectorAll(".dropdown-container")
//     .forEach(function (container) {
//       container.classList.remove("dropdown-open");
//     });

//   document.querySelectorAll(".dropdown-menu").forEach(function (menu) {
//     menu.classList.remove("dropdown-active");
//   });
// }

// // close the dropdown on mouse out from the dropdown list
// document.querySelectorAll(".dropdown-menu").forEach(function (dropDownList) {
//   // close the dropdown after user leaves the list
//   dropDownList.onmouseleave = closeDropdown;
// });
// // close the dropdown on mouse out from the dropdown list
// document
//   .querySelectorAll(".dropdown-toggle.hover-dropdown")
//   .forEach(function (dropDownList) {
//     // close the dropdown after user leaves the list
//     dropDownList.onmouseleave = closeDropdown;
//   });
