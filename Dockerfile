# Stage 1: Build Frontend
FROM node:20-alpine AS frontend-build
WORKDIR /app/frontend
COPY frontend/package*.json ./
RUN npm install
COPY frontend/ ./
RUN npm run build

# Stage 2: Build Backend
FROM node:20-alpine AS backend-build
WORKDIR /app/backend
COPY backend/package*.json ./
RUN npm install
COPY backend/ ./
RUN npm run build

# Stage 3: Production Runtime
FROM node:20-alpine
WORKDIR /app

# Install production dependencies for backend
COPY backend/package*.json ./
RUN npm install --omit=dev

# Copy backend build
COPY --from=backend-build /app/backend/dist ./dist

# Copy frontend build to public folder in backend (or separate static folder)
# We will need to configure Express to serve this
COPY --from=frontend-build /app/frontend/dist ./public

# Expose port (Cloud Run uses 8080 by default)
ENV PORT=8080
EXPOSE 8080

# Start command
CMD ["node", "dist/app.js"]
