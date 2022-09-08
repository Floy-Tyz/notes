export default {
    loadStore() {
        if (localStorage.getItem('store')) {
            try {
                this.replaceState(JSON.parse(localStorage.getItem('store')));
            } catch (e) {
                console.log('Could not initialize store', e);
            }
        }
    },
    setTodos(state, payload) {
        state.todos = payload
    },
    createTodos(state, payload) {
        if (payload !== null) {
            return state.todos.push(
                {
                    id: state.todos[state.todos.length - 1].id + 1,
                    title: payload,
                    tasks: []
                }
            )
        } else {
            console.log(payload)
        }
    },
    createTasks(state, payload, id) {

        let todoId = state.todos.find((x) => x.id === id)

        if (id !== undefined && payload.id !== undefined && typeof payload.title === 'string') {
            return state.todos.find((x) => x.id === id).tasks.push(
                {
                    id: todoId.tasks[todoId.tasks.length - 1].id + 1,
                    text: payload.text,
                    completed: payload.completed
                }
            )
        }
    },
    deleteTodos(state, id) {

        let removeItem = state.todos.find((x) => x.id === id)
        if (removeItem !== null) {
            return state.todos.splice(removeItem, 1)
        }
    },
    deleteTasks(state, payload, id) {
        let removeId = payload.id
        let toDo = state.todos.find((x) => x.id === id)
        let taskItem = toDo.find((x) => x.id === removeId)
        if (taskItem !== null) {
            return state.todos.find((x) => x.id === toDo.id).tasks.splice(taskItem, 1)
        }
    }
}