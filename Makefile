pack:
	cd blocks && ./node_modules/.bin/wp-scripts build
	git commit -am "build"
	git push
	-rm -f woocommerce-other-payment-gateway.zip && git archive --prefix=woocommerce-other-payment-gateway/ -o woocommerce-other-payment-gateway.zip HEAD;
