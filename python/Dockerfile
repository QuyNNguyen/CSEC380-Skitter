FROM python:2.7

WORKDIR /usr/src/app

COPY functions.py ./
COPY requirements.txt ./
RUN pip install -r requirements.txt

COPY . .

CMD [ "python", "./functions.py" ]
