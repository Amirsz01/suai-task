new Vue({
    delimiters: ['${', '}'],
    el: '#app',
    data: {
        groups: [],
        students: [],
        tasks: [],
        count: 0,
        id: null
    },
    methods: {
        getTaskInfo: function () {
            fetch('/task/info/get', {
                method: 'POST',
                body: JSON.stringify({id: this.id})
            })  
                .then((response) => {
                    if(response.ok) {
                        return response.json();
                    }
                    throw new Error('Network response was not ok');
                })
                .then((json) => {
                    this.groups = json.groups ?? []
                    this.students = json.students ?? []
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getTasksByStudent: function () {
            fetch('/student/tasks/get', {
                method: 'POST',
                body: JSON.stringify({id: this.id})
            })  
                .then((response) => {
                    if(response.ok) {
                        return response.json();
                    }
                    throw new Error('Network response was not ok');
                })
                .then((json) => {
                    this.tasks = json.tasks ?? []
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getStudentsByClasses: function () {
            fetch('/classes/students/get', {
                method: 'POST',
                body: JSON.stringify({id: this.id})
            })  
                .then((response) => {
                    if(response.ok) {
                        return response.json();
                    }
                    throw new Error('Network response was not ok');
                })
                .then((json) => {
                    this.students = json.students ?? []
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getStudentsCountByTask: function () {
            fetch('/task/students/count/get', {
                method: 'POST',
                body: JSON.stringify({id: this.id})
            })  
                .then((response) => {
                    if(response.ok) {
                        return response.json();
                    }
                    throw new Error('Network response was not ok');
                })
                .then((json) => {
                    this.count = json.count ?? 'None'
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    }
});