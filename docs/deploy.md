# Deploy to staging/production

When deploying live we use [Servebolt](https://admin.servebolt.com/account) as server company and execude CD/CI through [buddy.works](https://app.buddy.works/netliferesearch). Credentials to log in to both services are stored in "tekadmin" vault in 1password. Check with Togga, Nils, Anna, Alex or admin to get help with that.

## Servebolt

1. Add new bolt, give it a name
2. Choose "Velg other CMS"
3. In Advanced option choose PHP 8.3
4. Choose Oslo timezone

## Buddy works

1. Create a new project.
2. Create a new pipline. Base it on an existing one - make a copy of one of the recent projects based on Craft CMS (duplicate).
3. Go to Variables and change PROJECT_URL, REMOTE_PROJECT_ROOT, REMOTE_SSH_HOST og REMOTE_SSH_USER (with credentials from Servebolt). Remove word "/public/" in REMOTE_PROJECT_ROOT.
4. Get a private SSH key from buddy and generate it in the project (on server). You find the command in Action:Atomic deploy. Paste it in the terminal:
   `echo -e 'ssh-ed25519 noenoenoe' >> ~/.ssh/authorized_keys`
   and then, to get the permissions:
   `chmod 0600 ~/.ssh/authorized_keys`
5. While on the server: create a folder releases
   `mkdir releases`
6. Remove public folder (it is from Servbolt)
   `rm -rf public/`
7. In buddy.works run the deploy (it will partially fail)
8. At the server create to symlinks: to wire craft to current
   `ln -nfs current/craft craft`
   and to wire public to current
   `ln -nfs current/public public`
9. Remember to create .env file at server with correct PRIMARY_SITE_URL!
10. Create an cookieValidationKey at the server with command
    `./craft setup/keys`

``

Atomic deploy commands:
if [ -d "releases/$BUDDY_EXECUTION_REVISION" ] && [ "$BUDDY_EXECUTION_REFRESH" = "true" ];
then
echo "Removing: releases/$BUDDY_EXECUTION_REVISION"
 rm -rf releases/$BUDDY_EXECUTION_REVISION;
fi

if [ ! -d "releases/$BUDDY_EXECUTION_REVISION" ];
then
echo "Creating: releases/$BUDDY_EXECUTION_REVISION"
 cp -dR deploy-cache releases/$BUDDY_EXECUTION_REVISION;
fi

echo "Creating: persistent directories"
mkdir -p storage
echo "Symlinking: persistent files & directories"
ln -nfs $REMOTE_PROJECT_ROOT/releases/$BUDDY_EXECUTION_REVISION/server-config/production.htaccess $REMOTE_PROJECT_ROOT/releases/$BUDDY_EXECUTION_REVISION/public/.htaccess
ln -nfs $REMOTE_PROJECT_ROOT/.env $REMOTE_PROJECT_ROOT/releases/$BUDDY_EXECUTION_REVISION
ln -nfs $REMOTE_PROJECT_ROOT/storage $REMOTE_PROJECT_ROOT/releases/$BUDDY_EXECUTION_REVISION

echo "Linking current to revision: $BUDDY_EXECUTION_REVISION"
rm -f current
ln -s releases/$BUDDY_EXECUTION_REVISION current

echo "Removing old releases"
cd releases && ls -t | tail -n +6 | xargs rm -rf
