"use strict";

// Calling todos from localStorage
let todos = getSavedTodos();

// Todo filters
const filters = {
   searchText: "",
   hideCompleted: false,
};

// Calling renderTodos function on main file
renderTodos(todos, filters);

// Searching todos
document.querySelector("#search").addEventListener("input", (e) => {
   filters.searchText = e.target.value;
   renderTodos(todos, filters);
});

// // Adding to-do on the list dynamically
// document.querySelector("#task-form").addEventListener("submit", (e) => {
//    // e.preventDefault();
//    const text = e.target.elements.text.value.trim();

//    if (text.length > 0) {
//       todos.push({
//          text: text,
//          completed: false,
//       });
//       saveTodos(todos);
//       renderTodos(todos, filters);
//       e.target.elements.text.value = "";
//    } else {
//       alert("Enter a value!");
//    }
// });

// Hiding todos
document.querySelector("#hide-completed").addEventListener("change", (e) => {
   filters.hideCompleted = e.target.checked;
   renderTodos(todos, filters);
});
