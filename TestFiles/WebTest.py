import shlex, subprocess

args = shlex.split("locust -f TestFiles/locustfile.py --host=http://localhost")

p1 = subprocess.call(args)


