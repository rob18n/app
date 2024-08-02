# Use an official Node.js image as the base
FROM node:18-alpine

# Set the working directory
WORKDIR /app

# Copy the package.json and install dependencies
COPY package*.json ./

RUN npm install

# Copy the rest of the application code
COPY . .

# Build the application
RUN npm run build

# Expose the port for the development server
EXPOSE 3112

# Start the Vite development server
CMD ["npm", "run", "dev", "--", "--host"]
