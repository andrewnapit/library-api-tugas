pipeline {
    agent any
    environment {
        // Ganti dengan username Docker Anda
        IMAGE_NAME = '<andrewnapitupulu>/library-api-tugas'
    }
    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/andrewnapit/library-api-tugas.git'
            }
        }
        stage('Build Docker Image') {
            steps {
                bat "docker build -t ${IMAGE_NAME}:latest ."
            }
        }
        stage('Push Docker Image') {
            steps {
                withCredentials([string(credentialsId: 'docker-token', variable: 'DOCKER_TOKEN')]) {
                    bat "docker login -u <USERNAME_DOCKER_ANDA> -p ${DOCKER_TOKEN}"
                    bat "docker push ${IMAGE_NAME}:latest"
                }
            }
        }
    }
}
