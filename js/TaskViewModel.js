// TaskViewModel.js - O cérebro do Front-end
class TaskViewModel {
    constructor() {
        this.tasks = []; // O "Estado" da aplicação (Model no lado do cliente)
        this.init();
    }

    async init() {
        // Mapeia elementos da View
        this.listElement = document.getElementById('taskList');
        this.inputElement = document.getElementById('taskTitle');
        this.dueDateElement = document.getElementById('taskDueDate');
        this.responsibleElement = document.getElementById('taskResponsible');
        this.addBtn = document.getElementById('addBtn');

        // Eventos da View que disparam ações na ViewModel
        this.addBtn.onclick = () => this.addTask();

        // Busca os dados iniciais
        await this.fetchTasks();
    }

    // Busca dados da API PHP
    async fetchTasks() {
        const response = await fetch('api.php?action=list');
        if (!response.ok) {
            console.error('Erro ao buscar tarefas', response.status);
            return;
        }
        this.tasks = (await response.json()).map(task => ({
            ...task,
            done: Number(task.done) === 1
        }));
        this.render(); // Atualiza a View (Data Binding)
    }

    async addTask() {
        const title = this.inputElement.value;
        const dueDate = this.dueDateElement.value;
        const responsible = this.responsibleElement.value;

        if (!title || !dueDate || !responsible) {
            return alert("Preencha título, data e responsável.");
        }

        await fetch('api.php?action=create', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ title: title, description: '', due_date: dueDate, responsible: responsible })
        });

        this.inputElement.value = '';
        this.dueDateElement.value = '';
        this.responsibleElement.value = '';
        await this.fetchTasks();
    }

    async deleteTask(id) {
        await fetch(`api.php?action=delete&id=${id}`);
        await this.fetchTasks();
    }

    async completeTask(id) {
        await fetch(`api.php?action=complete&id=${id}`);
        await this.fetchTasks();
    }

    // O "Binder": Sincroniza o array de tarefas com o HTML
    render() {
        this.listElement.innerHTML = '';
        this.tasks.forEach(task => {
            const li = document.createElement('li');
            li.className = task.done ? 'done' : '';
            li.innerHTML = `
                <span>${task.title}</span>
                <button class="complete" onclick="vm.completeTask(${task.id})">✔️</button>
                <button class="delete" onclick="vm.deleteTask(${task.id})">❌</button>
            `;
            this.listElement.appendChild(li);
        });
    }
}

// Instancia a ViewModel
const vm = new TaskViewModel();
