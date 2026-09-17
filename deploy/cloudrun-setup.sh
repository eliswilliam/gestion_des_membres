#!/bin/sh
# Configuration Cloud Run pour gestion-des-membres
# Projet : vertex-livre-90861 | Cloud SQL : eejc-db | Bucket : eejc-uploads-vertex-livre-90861

set -e

PROJECT=vertex-livre-90861
REGION=us-central1
SERVICE=gestion-des-membres
CLOUDSQL=vertex-livre-90861:us-central1:eejc-db
BUCKET=eejc-uploads-vertex-livre-90861
NEON_URL="postgresql://neondb_owner:npg_9vPbSUe0ZMTo@ep-polished-haze-ad2uomrp.c-2.us-east-1.aws.neon.tech/neondb?sslmode=require"

gcloud run services update "$SERVICE" \
  --project="$PROJECT" \
  --region="$REGION" \
  --clear-cloudsql-instances \
  --update-env-vars="DB_CONNECTION=pgsql,DB_HOST=ep-polished-haze-ad2uomrp.c-2.us-east-1.aws.neon.tech,DB_PORT=5432,DB_DATABASE=neondb,DB_USERNAME=neondb_owner,DB_PASSWORD=npg_9vPbSUe0ZMTo,DB_URL=${NEON_URL},FILESYSTEM_DISK=gcs,GOOGLE_CLOUD_PROJECT=${PROJECT},GCS_BUCKET=${BUCKET},RUN_MIGRATIONS=true,FRESH_MIGRATIONS=false" \
  --remove-env-vars="DB_SOCKET"

echo "Cloud Run mis à jour avec Neon PostgreSQL : https://${SERVICE}-x5rxgwi5tq-uc.a.run.app"
