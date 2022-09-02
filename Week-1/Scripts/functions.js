"use strict";

const getSavedTodos = () => {
   const todosJSON = localStorage.getItem("todos");

   if (todosJSON !== null) {
      return JSON.parse(todosJSON);
   } else {
      return [];
   }
};

const saveTodos = (todos) => {
   localStorage.setItem("todos", JSON.stringify(todos));
};

function deleteTodo(deleteTodo) {
   let todos = getSavedTodos();
   todos.forEach(function (todo, index) {
      if (todo.text.trim() === deleteTodo) {
         todos.splice(index, 1);
      }
   });

   localStorage.setItem("todos", JSON.stringify(todos));
}

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

const generateTodoDOM = (todo) => {
   const todoEl = document.createElement("label");
   const containerEl = document.createElement("div");
   const checkbox = document.createElement("input");
   const todoText = document.createElement("span");
   // const actions = document.createElement("div");
   const removeBtn = document.createElement("button");
   const editBtn = document.createElement("button");

   checkbox.setAttribute("type", "checkbox");
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

   removeBtn.textContent = "REMOVE";
   removeBtn.classList.add("removeButton");
   todoEl.appendChild(removeBtn);
   removeBtn.addEventListener("click", (e) => {
      removeBtn.textContent = "";
      e.target.parentElement.remove();
      deleteTodo(e.target.parentElement.textContent.trim());
   });

   // editBtn.textContent = "EDIT";
   // editBtn.classList.add("removeButton");
   // todoEl.appendChild(editBtn);

   return todoEl;
};

const generateSummaryDOM = (incompletedTodos) => {
   const summary = document.createElement("h2");
   summary.textContent = `You have ${incompletedTodos.length} todos left`;
   return summary;
};
