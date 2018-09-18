from locust import HttpLocust, TaskSet, task

class WebTest(TaskSet):

    def on_start(self):
        self.login()

    @task
    def index(self):
        selc.client.get('/')

class WebsiteUser(HttpLocust):
    task_set = WebTest
