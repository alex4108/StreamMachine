set -e
set -o pipefail

cd node-media-server
docker build -t alex4108/streammachine:nms .
cd ../web
docker build -t alex4108/streammachine:web .
if [[ "${DEV}" != "1" ]]; then
	docker push alex4108/streammachine:nms
	docker push alex4108/streammachine:web
fi
