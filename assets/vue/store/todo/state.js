const state = ()=> {
    return {
        todos: [
            {
                id: 1,
                title: 'День 1',
                tasks: [
                    {id: 1, text: 'Создать стор', completed: true},
                    {id: 2, text: 'Добавить мутации', completed: false},
                ]
            }
        ]
    }
}

export default state