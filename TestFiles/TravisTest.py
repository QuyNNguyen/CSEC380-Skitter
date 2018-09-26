from locust import HttpLocust, TaskSet, task

class WebTest(TaskSet):
    def on_start(self):
        self.index()

    @task
    def index(self):
        self.client.get("/")

class WebsiteUser(HttpLocust):
    task_set = WebTest
