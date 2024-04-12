FROM node:18-alpine
WORKDIR /var/www/ui
COPY package.json /var/www/ui/
COPY package-lock.json /var/www/ui/
RUN npm install
RUN npm install react-router-dom --save
RUN npm install axios --save
COPY . /var/www/ui
RUN npm run build
CMD npm start