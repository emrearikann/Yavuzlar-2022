"use strict";

let todos = getSavedTodos();

const filters = {
   searchText: "",
   hideCompleted: false,
};

renderTodos(todos, filters);

document.querySelector("#search").addEventListener("input", (e) => {
   filters.searchText = e.target.value;
   renderTodos(todos, filters);
});

document.querySelector("#task-form").addEventListener("submit", (e) => {
   const text = e.target.elements.text.value.trim();
   e.preventDefault();

   if (text.length > 0) {
      todos.push({
         text: text,
         completed: false,
      });
      saveTodos(todos);
      renderTodos(todos, filters);
      e.target.elements.text.value = "";
   } else {
      alert("Enter a value!");
   }
});

document.querySelector("#hide-completed").addEventListener("change", (e) => {
   filters.hideCompleted = e.target.checked;
   renderTodos(todos, filters);
});
