import shlex, subprocess

args = "locust -f TestFiles/locustfile.py --host=http://localhost"

p1 = subprocess.call(args, shell=True)


