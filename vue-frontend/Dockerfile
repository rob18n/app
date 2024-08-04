# Build stage
FROM node:18-alpine as build-stage

# Set the working directory
WORKDIR /app

# Copy the package.json and install dependencies
COPY package*.json ./

RUN npm install

# Copy the rest of the application code
COPY . .

# Build the application for production
RUN npm run build

# Production stage
FROM nginx:stable-alpine as production-stage

# Copy the built files from the build stage
COPY --from=build-stage /app/dist /usr/share/nginx/html

# Expose the port that Nginx will use
EXPOSE 80

# Start Nginx
CMD ["nginx", "-g", "daemon off;"]
