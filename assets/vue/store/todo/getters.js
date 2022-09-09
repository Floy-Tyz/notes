// export const todos = (state)=>
// {
//     return state.todos
// }

export default {
    todos(state){
        return state.todos
    },
    oneToDo(state, slug){
      return state.todos.find(x=>x.slug===slug)
    }
}
