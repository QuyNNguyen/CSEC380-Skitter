import shlex, subprocess

args = shlex.split("locust --host://localhost")

p1 = subprocess.Popen(args)


