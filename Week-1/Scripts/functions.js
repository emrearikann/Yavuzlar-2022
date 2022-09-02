"use strict";

// Creating 'todos' object.
const getSavedTodos = () => {
   const todosJSON = localStorage.getItem("todos");

   if (todosJSON !== null) {
      return JSON.parse(todosJSON);
   } else {
      return [];
   }
};

// Save todos to localStorage
const saveTodos = (todos) => {
   localStorage.setItem("todos", JSON.stringify(todos));
};

// Remove todo from localStorage
function deleteTodo(deleteTodo) {
   let todos = getSavedTodos();
   todos.forEach(function (todo, index) {
      if (todo.text.trim() === deleteTodo) {
         todos.splice(index, 1);
      }
   });
   localStorage.setItem("todos", JSON.stringify(todos));
   window.location.reload();
   renderTodos(todos, filters);
}

// Todo filtering and hiding (it's using 'searchText' filter and 'hideCompleted' filter to do that and we took it from main.js
// (commented as 'searching todos' and 'hiding todos'))
const renderTodos = (todos, filters) => {
   const filteredTodos = todos.filter((todo) => {
      const searchTextMatch = todo.text.toLowerCase().includes(filters.searchText.toLowerCase());
      const hideCompletedMatch = !filters.hideCompleted || !todo.completed;
      return searchTextMatch && hideCompletedMatch;
   });

   const incompletedTodos = filteredTodos.filter((todo) => {
      return !todo.completed;
   });

   document.querySelector(".content").innerHTML = "";
   document.querySelector(".content").appendChild(generateSummaryDOM(incompletedTodos));

   filteredTodos.forEach((todo) => {
      document.querySelector(".content").appendChild(generateTodoDOM(todo));
   });
};

// Creating list on DOM object, setting attributes, setting button actions and styling them dynamically
const generateTodoDOM = (todo) => {
   const todoEl = document.createElement("label");
   const containerEl = document.createElement("div");
   const checkbox = document.createElement("input");
   const todoText = document.createElement("span");
   const actions = document.createElement("div");
   const removeBtn = document.createElement("button");
   const editBtn = document.createElement("button");

   checkbox.setAttribute("type", "checkbox");
   checkbox.setAttribute("style", "cursor: pointer;");
   checkbox.checked = todo.completed;
   containerEl.appendChild(checkbox);

   if (todo.completed) {
      containerEl.classList.add("todoDone");
   } else {
      containerEl.classList.remove("todoDone");
   }

   checkbox.addEventListener("click", (e) => {
      todo.completed = e.target.checked;
      localStorage.setItem("todos", JSON.stringify(todos));

      renderTodos(todos, filters);
   });

   todoText.textContent = todo.text;
   todoText.classList.add("todoSpan");
   containerEl.appendChild(todoText);

   todoEl.classList.add("todoListItem");
   containerEl.classList.add("containerTodoListItem");
   todoEl.appendChild(containerEl);

   todoEl.appendChild(actions);

   editBtn.textContent = "EDIT";
   editBtn.classList.add("removeButton");
   actions.appendChild(editBtn);

   editBtn.addEventListener("click", (e) => {
      if (editBtn.textContent === "EDIT") {
         editBtn.textContent = "SAVE";
      }
      if (editBtn.textContent === "SAVE") {
         editBtn.textContent = "EDIT";
      }
      let todos = JSON.parse(localStorage.todos);
      for (var i = 0; i < todos.length; i++) {
         if (e.target.parentElement.parentElement.firstElementChild.textContent === todos[i].text) {
            todoText.contentEditable = true;
            todoText.focus();
            todoText.textContent = "";
            editBtn.textContent = "SAVE";
            break;
         }
         todos[i].text = todoText.textContent;
      }
      localStorage.setItem("todos", JSON.stringify(todos));
   });

   removeBtn.textContent = "REMOVE";
   removeBtn.classList.add("removeButton");
   actions.appendChild(removeBtn);

   removeBtn.addEventListener("click", (e) => {
      removeBtn.textContent = "";
      editBtn.textContent = "";
      e.target.parentElement.parentElement.remove();
      deleteTodo(e.target.parentElement.parentElement.textContent.trim());
   });

   return todoEl;
};

// Printing how many todos are left
const generateSummaryDOM = (incompletedTodos) => {
   const summary = document.createElement("h2");
   summary.textContent = `You have ${incompletedTodos.length} todos left`;
   return summary;
};
