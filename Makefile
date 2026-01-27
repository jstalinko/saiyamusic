.PHONY: commit push auto

commit_message := $(shell \
    git status --porcelain | awk '{print $$2}' | paste -sd "," - \
)

commit:
	@if [ -z "$$(git status --porcelain)" ]; then \
		echo "No changes to commit"; \
	else \
		echo "Committing with message: update: $(commit_message)"; \
		git add .; \
		git commit -m "update: $(commit_message)"; \
	fi

push:
	@git push origin main

auto: commit push
