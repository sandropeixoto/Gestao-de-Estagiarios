#!/bin/bash

# Configuration
PROJECT_ID="SEU_PROJECT_ID_AQUI" # Substitua pelo seu ID do projeto GCP
APP_NAME="gestao-estagio"
REGION="us-central1"
IMAGE_TAG="gcr.io/$PROJECT_ID/$APP_NAME"

# Colors
GREEN='\033[0;32m'
NC='\033[0m' # No Color

echo -e "${GREEN}=== Iniciando Deploy para Google Cloud Run ===${NC}"

# 1. Build Docker Image
echo -e "${GREEN}1. Construindo imagem Docker...${NC}"
docker build --no-cache -t $APP_NAME .

# 2. Tag Image
echo -e "${GREEN}2. Taggeando imagem para GCR...${NC}"
docker tag $APP_NAME $IMAGE_TAG

# 3. Push to GCR
echo -e "${GREEN}3. Enviando imagem para o Container Registry...${NC}"
docker push $IMAGE_TAG

# 4. Deploy to Cloud Run
echo -e "${GREEN}4. Realizando deploy no Cloud Run...${NC}"
echo "Certifique-se de que as variáveis de ambiente (DB_HOST, etc) estão configuradas."

gcloud run deploy $APP_NAME \
  --image $IMAGE_TAG \
  --platform managed \
  --region $REGION \
  --allow-unauthenticated \
  --port 8080

echo -e "${GREEN}=== Deploy Concluído! ===${NC}"
