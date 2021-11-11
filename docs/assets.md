# Handling assets across environments

We usually use S3 on Amazon Web Services. By storing assets in S3 we have an easier time switching between various server environments without manually copying assets around.

S3 is a bit complicated to configure so we have created [AWS helper scripts here](https://github.com/netliferesearch/aws-helper-scripts). Be sure to use Netlife's AWS account.

**Gotcha:** Craft CMS doesn't support bucket location Frankfurt because it uses a newer authentication method.
