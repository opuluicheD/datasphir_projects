# eduroam FLR using Docker Swarm
Dockerized RADIUS proxy server for national roaming operators (NRO)

## Install Docker

https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-20-04

## Clone repository

    git clone https://gitlab.com/eko-konnect/external-ops/eduroam-flr-docker.git eduroam-flr
    cd eduroam-flr

You will need an account on the UbuntuNet Git repository and add an SSH key to your account in order to clone the code. Get in contact with us: devops@ubuntunet.net

## Configure RADIUS

    cp radius/clients.conf.example radius/clients.conf
    cp radius/proxy.conf.example radius/proxy.conf
    cp radius/users.example radius/users


## Deploy

There are two ways to deploy, either directly on the machine that you have cloned the repository or on one or more nodes of a swarm. The first approach is easier and straight-forward, the second approach allows the deploy multiple instances for fail-over or resilience.

### Deploy on local machine

#### Install Docker Compose

https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-20-04

#### Run container

    docker-compose up

#### Test correct functionality

Using the test user credentials defined in radius/users and the shared secret for localhost (see radius/clients.conf), make sure that RADIUS is running correctly.

    docker exec flr radtest <user> <passwd> localhost:1812 0 <secret>

    docker exec flr radtest alice allegra localhost:1812 0 testing123


### Deploy on Swarm

#### Create a Swarm

References: 
* https://docs.docker.com/engine/swarm/swarm-tutorial/create-swarm/
* https://docs.docker.com/get-started/part4/

Create at least one master node
```
docker swarm init --advertise-addr <IP address>
```

Join one or several worker nodes to the swarm using the token that you got when creating the master node above. Make sure TCP port 2377 is open on the master node
```
docker swarm join --token <token> <IP address>:2377
```
 
If you don't have the token handy, you can easily recover it
```
docker swarm join-token worker
```

Show the nodes in the swarm (Only works on the master node)
```
docker node ls
```

Delete a swarm
```
docker swarm leave          # Worker Node
docker swarm leave --force  # Manager Node
```

#### Add 'rps' label to the nodes

The docker-stack.yml script only runs containers on nodes that are labelled with 'component==flr'. Labels can be added to a node like this:

```
docker node update --label-add service=eduroam --label-add component=flr --label-add location=<eg. Johannesburg> --label-add provider=<eg. WACREN> <nodename>
```

#### Run a Stack

Deploy it
```
docker stack up -c docker-stack.yml <stackname>
```

List it
```
docker stack ps <stackname>
```

Remove it
```
docker stack rm <stackname>
```


## Firewall rules

It is highly recommend to setup a firewall on the RPS server and only allow connections from known upstream and downstream servers. 

We use ufw, the easy solution for Ubuntu.

Before enabling the firewall, allow SSH connections, in order not to lock yourself out:

```
sudo ufw app list
sudo ufw allow 'OpenSSH'
sudo ufw enable
sudo ufw status
```

Allow access from an up-/downstream server

```
sudo ufw allow in proto udp from <remote IP address> to <Our IP Address> port 1812
```

Replace 1812 with 1813 to allow acct access.

These are the entries that you'll want to add at the minimum:
```
# WACREN RPS
sudo ufw allow in proto udp from 192.87.106.34 to any port 1812
# UA RPS
sudo ufw allow in proto udp from 130.225.242.109 to any port 1812
