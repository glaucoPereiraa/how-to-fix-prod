FROM mysql:8.0

RUN microdnf install -y iproute && microdnf clean all

COPY ./docker/mysql/start.sh /start.sh
RUN chmod +x /start.sh

ENTRYPOINT ["/start.sh"]