var dominio_base="192.168.1.58";

export const environment = {
  production: true,
  serverSocket: 'ws://'+dominio_base+':3000',
  apiBase:"http://"+dominio_base+"/connectingpeople/api/web/",
  imagenesBase:"http://"+dominio_base+"/connectingpeople/api/imagenes/",
  intervalo_tiempo_reescaneo_chat_match:10000
};
