pipeline {
    agent any

    environment {
        IMAGE_NAME = 'moodquotes'
        CONTAINER_NAME = 'moodquotes-app'
        PORT = '9000'
    }

    stages {
        stage('Clone Repository') {
            steps {
                git branch: 'main',
                    url: 'https://github.com/ipoonawala9/MoodBasedQuoteGenerator.git'
            }
        }

        stage('Build Docker Image') {
            steps {
                sh 'docker build -t ${IMAGE_NAME}:${BUILD_NUMBER} .'
            }
        }

        stage('Deploy Container') {
            steps {
                sh '''
                    docker stop ${CONTAINER_NAME} || true
                    docker rm ${CONTAINER_NAME} || true
                    docker run -d \
                        --name ${CONTAINER_NAME} \
                        -p ${PORT}:80 \
                        ${IMAGE_NAME}:${BUILD_NUMBER}
                '''
            }
        }
    }

    post {
        success {
            echo "App deployed at http://localhost:${PORT}"
        }
        failure {
            sh 'docker stop ${CONTAINER_NAME} || true'
            echo 'Deployment failed.'
        }
    }
}
