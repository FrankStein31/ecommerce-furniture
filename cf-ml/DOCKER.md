# 🐳 Docker Deployment Guide

## Quick Start

### Menggunakan Docker Compose (Recommended)

```bash
# Build dan jalankan container
docker-compose up -d

# Cek logs
docker-compose logs -f

# Stop container
docker-compose down
```

### Menggunakan Docker (Manual)

```bash
# Build image
docker build -t spk-rekomendasi:latest .

# Run container
docker run -d \
  --name spk-api \
  -p 8000:8000 \
  -v "$(pwd)/data_skripsi.xlsx:/app/data_skripsi.xlsx:ro" \
  spk-rekomendasi:latest

# Cek logs
docker logs -f spk-api

# Stop container
docker stop spk-api
docker rm spk-api
```

---

## Akses API

Setelah container berjalan, akses:

- **API**: http://localhost:8000
- **Swagger Docs**: http://localhost:8000/docs
- **ReDoc**: http://localhost:8000/redoc

---

## Docker Commands Cheat Sheet

### Management Commands

```bash
# List running containers
docker ps

# List all containers
docker ps -a

# List images
docker images

# View logs
docker logs spk-api
docker logs -f spk-api  # Follow logs

# Restart container
docker restart spk-api

# Execute command in container
docker exec -it spk-api bash

# View container stats
docker stats spk-api
```

### Cleanup Commands

```bash
# Remove container
docker rm spk-api

# Remove image
docker rmi spk-rekomendasi:latest

# Remove all stopped containers
docker container prune

# Remove unused images
docker image prune

# Clean everything (use with caution!)
docker system prune -a
```

---

## Update Data Excel

Jika ingin update file `data_skripsi.xlsx`:

### Menggunakan Docker Compose:
1. Update file `data_skripsi.xlsx` di folder project
2. Restart container:
   ```bash
   docker-compose restart
   ```

### Menggunakan Docker:
1. Copy file baru ke container:
   ```bash
   docker cp data_skripsi.xlsx spk-api:/app/data_skripsi.xlsx
   ```
2. Restart container:
   ```bash
   docker restart spk-api
   ```

---

## Environment Variables

Bisa tambahkan environment variables di `docker-compose.yml`:

```yaml
environment:
  - FILE_PATH=data_skripsi.xlsx
  - DEFAULT_CF=0.8
  - LOG_LEVEL=info
```

Atau di command line:

```bash
docker run -e FILE_PATH=data_skripsi.xlsx -e DEFAULT_CF=0.8 ...
```

---

## Troubleshooting

### Container tidak start

```bash
# Cek logs untuk error
docker logs spk-api

# Cek status health check
docker inspect spk-api | grep -A 10 Health
```

### Port sudah digunakan

Ubah port mapping di `docker-compose.yml` atau command:

```bash
# Ganti 8000 dengan port lain, misal 8001
docker run -p 8001:8000 ...
```

### File Excel tidak ditemukan

Pastikan file `data_skripsi.xlsx` ada di folder yang sama dengan Dockerfile.

### Memory issues

Tambahkan memory limit:

```yaml
# docker-compose.yml
services:
  spk-api:
    mem_limit: 1g
    memswap_limit: 1g
```

---

## Production Deployment

### Menggunakan Docker Hub

```bash
# Tag image
docker tag spk-rekomendasi:latest username/spk-rekomendasi:v1.0

# Push ke Docker Hub
docker push username/spk-rekomendasi:v1.0

# Pull dan run di server production
docker pull username/spk-rekomendasi:v1.0
docker run -d -p 8000:8000 username/spk-rekomendasi:v1.0
```

### Menggunakan Docker Registry Private

```bash
# Tag untuk private registry
docker tag spk-rekomendasi:latest registry.example.com/spk-rekomendasi:v1.0

# Push ke private registry
docker push registry.example.com/spk-rekomendasi:v1.0
```

### Production Tips

1. **Gunakan reverse proxy** (Nginx/Traefik)
2. **Enable HTTPS** dengan SSL certificate
3. **Setup monitoring** (Prometheus, Grafana)
4. **Configure logging** ke external service
5. **Setup auto-restart** policy
6. **Use secrets** untuk sensitive data
7. **Regular backup** data Excel

---

## Multi-stage Build (Optional)

Untuk image yang lebih kecil, bisa gunakan multi-stage build:

```dockerfile
# Stage 1: Builder
FROM python:3.10-slim as builder
WORKDIR /app
COPY requirements.txt .
RUN pip install --user --no-cache-dir -r requirements.txt

# Stage 2: Runtime
FROM python:3.10-slim
WORKDIR /app
COPY --from=builder /root/.local /root/.local
COPY . .
ENV PATH=/root/.local/bin:$PATH
CMD ["uvicorn", "main:app", "--host", "0.0.0.0", "--port", "8000"]
```

---

## Docker Compose Advanced

### Multiple Services

```yaml
version: '3.8'

services:
  spk-api:
    build: .
    ports:
      - "8000:8000"
    depends_on:
      - redis
    environment:
      - REDIS_URL=redis://redis:6379

  redis:
    image: redis:alpine
    ports:
      - "6379:6379"
    volumes:
      - redis_data:/data

  nginx:
    image: nginx:alpine
    ports:
      - "80:80"
    volumes:
      - ./nginx.conf:/etc/nginx/nginx.conf:ro
    depends_on:
      - spk-api

volumes:
  redis_data:
```

---

## Testing Docker Image

```bash
# Test build
docker build -t spk-rekomendasi:test .

# Test run
docker run --rm -p 8000:8000 spk-rekomendasi:test

# Test API
curl http://localhost:8000/docs
```

---

## CI/CD Integration

### GitHub Actions Example

```yaml
name: Docker Build and Push

on:
  push:
    branches: [ main ]

jobs:
  build:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      
      - name: Build Docker image
        run: docker build -t spk-rekomendasi:latest .
      
      - name: Run tests
        run: docker run --rm spk-rekomendasi:latest pytest
      
      - name: Push to Docker Hub
        run: |
          echo ${{ secrets.DOCKER_PASSWORD }} | docker login -u ${{ secrets.DOCKER_USERNAME }} --password-stdin
          docker push username/spk-rekomendasi:latest
```

---

**Last Updated:** December 14, 2025
