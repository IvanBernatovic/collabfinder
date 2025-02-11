FROM nginx:1.25.4-alpine

COPY nginx.conf /etc/nginx/

EXPOSE 80
STOPSIGNAL SIGTERM

CMD ["nginx", "-g", "daemon off;"]