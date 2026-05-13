<?php

class TaskPresenter {
    private Task $model;
    private TaskViewInterface $view;

    public function __construct(Task $model, TaskViewInterface $view) {
        $this->model = $model;
        $this->view = $view;
    }

    public function index(): void {
        try {
            $tasks = $this->model->getAll();

            foreach ($tasks as &$task) {
                $task['title'] = strtoupper($task['title']);
            }

            $this->view->displayTasks($tasks);
        } catch (Exception $e) {
            $this->view->showError($e->getMessage());
        }
    }

    public function create(string $title, string $description, string $dueDate, string $responsible = ''): void {
        try {
            $this->model->save($title, $description, $dueDate, $responsible);
            header('Location: index.php');
            exit;
        } catch (Exception $e) {
            $this->view->showError($e->getMessage());
        }
    }

    public function complete($id): void {
        $this->model->complete($id);
        header('Location: index.php');
        exit;
    }

    public function delete($id): void {
        $this->model->delete($id);
        header('Location: index.php');
        exit;
    }
}
