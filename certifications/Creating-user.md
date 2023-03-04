# Creating a user in k8s cluster

This is a quick guide about how to create a new user, set necessary role permissions and issue SSL certificates in Kubernetes.

First generate a private key

```text
root@master:# openssl genrsa -out pidumenk.key 2048
Generating RSA private key, 2048 bit long modulus (2 primes)
.............................................+++++
.............................................+++++

root@master:# cat pidumenk.key
-----BEGIN RSA PRIVATE KEY-----
MIIEowIBAAKCAQEApkd61vcW2DhtSYdYYp17qUlY0BmQNnXfpTWvnqUNNMCxQgOz
/--------------------------------------------------------------/
70c/4zlnduXsGUuArGibElEz0trHwTdlqCE05cUR+lrb09ELLm96
-----END RSA PRIVATE KEY-----
```

Now create a CSR file

```text
root@master:# openssl req -new -key pidumenk.key -subj "/CN=pidumenk" -out pidumenk.csr
root@master:# openssl req -noout -text -in pidumenk.csr
Certificate Request:
    Data:
        Version: 0 (0x0)
        Subject: CN=pidumenk
        Subject Public Key Info:
            Public Key Algorithm: rsaEncryption
                RSA Public-Key: (2048 bit)
                Modulus:
                    00:a6:47:7a:d6:f7:16:d8:38:6d:49:87:58:62:9d:
                    7b:a9:49:58:d0:19:90:36:75:df:a5:35:af:9e:a5:
                    0d:34:c0:b1:42:03:b3:1b:a5:7b:a8:ec:e8:5f:ec:
                    2a:b7:65:c1:28:61:ee:49:63:e9:6c:48:68:ad:43:
                    04:3a:74:cb:7f:27:28:ce:e7:e9:e4:e8:1e:70:35:
                    50:c6:9a:89:cd:22:3f:59:a8:57:c9:78:db:ce:10:
                    c9:a3:fd:50:19:a5:d8:11:cf:fb:0c:14:00:e6:4f:
                    2b:24:03:02:d0:3b:44:8b:e9:e6:9e:8f:25:b4:43:
                    13:87:84:2c:ec:d3:7e:ef:b1:94:d0:cf:ee:98:8a:
                    96:08:c5:52:51:7b:e8:31:b1:95:95:72:ed:25:42:
                    9e:bb:e6:96:b4:5d:dc:ab:a9:fc:2c:e0:f6:55:0e:
                    53:dc:b8:e0:17:d1:fe:41:aa:ba:25:fc:0b:96:63:
                    bb:fa:a5:c1:c9:5c:5e:b4:2e:ff:fb:65:be:f0:f1:
                    d2:13:5f:67:c8:d6:dc:47:65:57:50:df:00:e9:40:
                    c3:0e:4b:e1:a1:51:5c:8a:c3:69:ea:30:34:3e:a5:
                    b9:87:af:45:4d:40:5e:9d:f7:61:57:9c:87:f2:79:
                    72:6a:47:70:3b:02:a3:20:3b:c5:19:81:c0:89:e4:
                    96:6b
                Exponent: 65537 (0x10001)
        Attributes:
            a0:00
    Signature Algorithm: sha256WithRSAEncryption
         37:9b:c7:9d:8b:dc:2c:6a:93:20:f3:1f:14:f6:c0:8b:57:05:
         eb:65:aa:8b:7c:f5:97:39:bb:71:a7:b4:6d:56:bc:57:eb:52:
         9e:fd:0c:e3:3a:71:99:fd:b9:be:38:e0:f5:25:67:a0:8d:ac:
         ef:ad:7a:37:8a:a4:5b:c4:5d:ec:78:14:cc:66:d3:f9:64:ee:
         85:c3:14:56:3e:df:7e:47:6f:b3:68:ca:69:72:8c:08:f0:df:
         e6:96:51:a6:67:63:19:c5:db:4b:0e:3a:d7:5a:f9:5f:80:74:
         44:c8:b6:59:e4:c9:f2:10:c3:28:3c:db:ce:c9:80:f9:82:4a:
         3e:3a:ff:ef:88:ec:a0:88:77:cd:7d:08:80:c3:db:69:1d:28:
         36:d0:02:17:23:fc:5e:8b:f2:4c:d5:c6:56:28:0f:c7:8d:bb:
         1e:df:b9:3b:79:1e:fd:a6:c7:eb:0c:7e:69:3b:80:d0:f7:a2:
         9c:eb:18:fd:a8:af:91:06:ee:7f:1c:44:fa:17:52:17:86:16:
         60:ac:d1:f8:5b:2b:26:89:4e:bf:4a:97:e3:ae:8c:3e:d0:b4:
         ab:68:35:97:4a:20:69:f1:5b:07:7b:55:45:22:2a:03:a3:f9:
         d1:5e:16:6e:46:31:62:ec:be:7c:81:fd:cd:69:7f:f3:9d:8e:
         80:21:e2:97
```

Then we need this file in base64

```text
root@master:# cat pidumenk.csr | base64
LS0tLS1CRUdJTiBDRVJUSUZJQ0FURSBSRVFVRVNULS0tLS0KTUlJQ1dEQ0NBVUFDQVFBd0V6RVJNQThHQTFVRUF3d0ljR2xrZFcxbGJtc3dnZ0VpTUEwR0NTcUdTSWIzRFFFQgpBUVVBQTRJQkR3QXdnZ0VLQW9JQkFRQ21SM3JXOXhiWU9HMUpoMWhpblh1cFNWalFHWkEyZGQrbE5hK2VwUTAwCndMRkNBN01icFh1bzdPaGY3Q3EzWmNFb1llNUpZK2xzU0dpdFF3UTZkTXQvSnlqTzUrbms2QjV3TlZER21vbk4KSWo5WnFGZkplTnZPRU1tai9WQVpwZGdSei9zTUZBRG1UeXNrQXdMUU8wU0w2ZWFlanlXMFF4T0hoQ3pzMDM3dgpzWlRReis2WWlwWUl4VkpSZStneHNaV1ZjdTBsUXA2NzVwYTBYZHlycWZ3czRQWlZEbFBjdU9BWDBmNUJxcm9sCi9BdVdZN3Y2cGNISlhGNjBMdi83WmI3dzhkSVRYMmZJMXR4SFpWZFEzd0RwUU1NT1MrR2hVVnlLdzJucU1EUSsKcGJtSHIwVk5RRjZkOTJGWG5JZnllWEpxUjNBN0FxTWdPOFVaZ2NDSjVKWnJBZ01CQUFHZ0FEQU5CZ2txaGtpRwo5dzBCQVFzRkFBT0NBUUVBTjV2SG5ZdmNMR3FUSVBNZkZQYkFpMWNGNjJXcWkzejFsem03Y2FlMGJWYThWK3RTCm52ME00enB4bWYyNXZqamc5U1Zub0kyczc2MTZONHFrVzhSZDdIZ1V6R2JUK1dUdWhjTVVWajdmZmtkdnMyaksKYVhLTUNQRGY1cFpScG1kakdjWGJTdzQ2MTFyNVg0QjBSTWkyV2VUSjhoRERLRHpienNtQStZSktQanIvNzRqcwpvSWgzelgwSWdNUGJhUjBvTnRBQ0Z5UDhYb3Z5VE5YR1ZpZ1B4NDI3SHQrNU8za2UvYWJINnd4K2FUdUEwUGVpCm5Pc1kvYWl2a1FidWZ4eEUraGRTRjRZV1lLelIrRnNySm9sT3YwcVg0NjZNUHRDMHEyZzFsMG9nYWZGYkIzdFYKUlNJcUE2UDUwVjRXYmtZeFl1eStmSUg5eldsLzg1Mk9nQ0hpbHc9PQotLS0tLUVORCBDRVJUSUZJQ0FURSBSRVFVRVNULS0tLS0K
```

Let's create a CSR object using this base64 input

```yaml
apiVersion: certificates.k8s.io/v1
kind: CertificateSigningRequest
metadata:
  name: pidumenk
spec:
  request: LS0tLS1CRUdJTiBDRVJUSUZJQ0FURSBSRVFVRVNULS0tLS0KTUlJQ1dEQ0NBVUFDQVFBd0V6RVJNQThHQTFVRUF3d0ljR2xrZFcxbGJtc3dnZ0VpTUEwR0NTcUdTSWIzRFFFQgpBUVVBQTRJQkR3QXdnZ0VLQW9JQkFRQ21SM3JXOXhiWU9HMUpoMWhpblh1cFNWalFHWkEyZGQrbE5hK2VwUTAwCndMRkNBN01icFh1bzdPaGY3Q3EzWmNFb1llNUpZK2xzU0dpdFF3UTZkTXQvSnlqTzUrbms2QjV3TlZER21vbk4KSWo5WnFGZkplTnZPRU1tai9WQVpwZGdSei9zTUZBRG1UeXNrQXdMUU8wU0w2ZWFlanlXMFF4T0hoQ3pzMDM3dgpzWlRReis2WWlwWUl4VkpSZStneHNaV1ZjdTBsUXA2NzVwYTBYZHlycWZ3czRQWlZEbFBjdU9BWDBmNUJxcm9sCi9BdVdZN3Y2cGNISlhGNjBMdi83WmI3dzhkSVRYMmZJMXR4SFpWZFEzd0RwUU1NT1MrR2hVVnlLdzJucU1EUSsKcGJtSHIwVk5RRjZkOTJGWG5JZnllWEpxUjNBN0FxTWdPOFVaZ2NDSjVKWnJBZ01CQUFHZ0FEQU5CZ2txaGtpRwo5dzBCQVFzRkFBT0NBUUVBTjV2SG5ZdmNMR3FUSVBNZkZQYkFpMWNGNjJXcWkzejFsem03Y2FlMGJWYThWK3RTCm52ME00enB4bWYyNXZqamc5U1Zub0kyczc2MTZONHFrVzhSZDdIZ1V6R2JUK1dUdWhjTVVWajdmZmtkdnMyaksKYVhLTUNQRGY1cFpScG1kakdjWGJTdzQ2MTFyNVg0QjBSTWkyV2VUSjhoRERLRHpienNtQStZSktQanIvNzRqcwpvSWgzelgwSWdNUGJhUjBvTnRBQ0Z5UDhYb3Z5VE5YR1ZpZ1B4NDI3SHQrNU8za2UvYWJINnd4K2FUdUEwUGVpCm5Pc1kvYWl2a1FidWZ4eEUraGRTRjRZV1lLelIrRnNySm9sT3YwcVg0NjZNUHRDMHEyZzFsMG9nYWZGYkIzdFYKUlNJcUE2UDUwVjRXYmtZeFl1eStmSUg5eldsLzg1Mk9nQ0hpbHc9PQotLS0tLUVORCBDRVJUSUZJQ0FURSBSRVFVRVNULS0tLS0K
  signerName: kubernetes.io/kube-apiserver-client
  expirationSeconds: 86400  # one day
  usages:
  - client auth
```

Then approve it

```text
root@master:# k apply -f pidumenk-csr.yaml
certificatesigningrequest.certificates.k8s.io/pidumenk created

root@master:# k get csr
NAME       AGE   SIGNERNAME                            REQUESTOR       REQUESTEDDURATION   CONDITION
pidumenk   6s    kubernetes.io/kube-apiserver-client   minikube-user   24h                 Pending

root@master:# k certificate approve pidumenk
certificatesigningrequest.certificates.k8s.io/pidumenk approved

root@master:# k get csr
NAME       AGE     SIGNERNAME                            REQUESTOR       REQUESTEDDURATION   CONDITION
pidumenk   2m38s   kubernetes.io/kube-apiserver-client   minikube-user   24h                 Approved,Issued
```

Now we need to create a public cert for pidumenk

```text
root@master: kubectl get csr pidumenk -o jsonpath='{.status.certificate}'| base64 -d > pidumenk.crt

root@master: openssl x509 -in pidumenk.crt -text -noout
Certificate:
    Data:
        Version: 3 (0x2)
        Serial Number:
            b6:43:6b:32:1a:e6:e0:88:c6:32:44:16:b5:73:53:4d
    Signature Algorithm: sha256WithRSAEncryption
        Issuer: CN=minikubeCA
        Validity
            Not Before: Mar  4 22:04:10 2023 GMT
            Not After : Mar  5 22:04:10 2023 GMT
        Subject: CN=pidumenk
        Subject Public Key Info:
            Public Key Algorithm: rsaEncryption
                RSA Public-Key: (2048 bit)
                Modulus:
                    00:a6:47:7a:d6:f7:16:d8:38:6d:49:87:58:62:9d:
                    7b:a9:49:58:d0:19:90:36:75:df:a5:35:af:9e:a5:
                    0d:34:c0:b1:42:03:b3:1b:a5:7b:a8:ec:e8:5f:ec:
                    2a:b7:65:c1:28:61:ee:49:63:e9:6c:48:68:ad:43:
                    04:3a:74:cb:7f:27:28:ce:e7:e9:e4:e8:1e:70:35:
                    50:c6:9a:89:cd:22:3f:59:a8:57:c9:78:db:ce:10:
                    c9:a3:fd:50:19:a5:d8:11:cf:fb:0c:14:00:e6:4f:
                    2b:24:03:02:d0:3b:44:8b:e9:e6:9e:8f:25:b4:43:
                    13:87:84:2c:ec:d3:7e:ef:b1:94:d0:cf:ee:98:8a:
                    96:08:c5:52:51:7b:e8:31:b1:95:95:72:ed:25:42:
                    9e:bb:e6:96:b4:5d:dc:ab:a9:fc:2c:e0:f6:55:0e:
                    53:dc:b8:e0:17:d1:fe:41:aa:ba:25:fc:0b:96:63:
                    bb:fa:a5:c1:c9:5c:5e:b4:2e:ff:fb:65:be:f0:f1:
                    d2:13:5f:67:c8:d6:dc:47:65:57:50:df:00:e9:40:
                    c3:0e:4b:e1:a1:51:5c:8a:c3:69:ea:30:34:3e:a5:
                    b9:87:af:45:4d:40:5e:9d:f7:61:57:9c:87:f2:79:
                    72:6a:47:70:3b:02:a3:20:3b:c5:19:81:c0:89:e4:
                    96:6b
                Exponent: 65537 (0x10001)
        X509v3 extensions:
            X509v3 Extended Key Usage:
                TLS Web Client Authentication
            X509v3 Basic Constraints: critical
                CA:FALSE
            X509v3 Authority Key Identifier:
                keyid:54:F4:F4:D5:61:C6:D8:F4:64:94:24:62:06:87:9A:2B:7C:D7:3F:A5

    Signature Algorithm: sha256WithRSAEncryption
         b5:42:4b:c9:fb:4f:44:c7:e0:66:a4:99:df:cd:d1:0c:41:6d:
         ed:d4:fe:1d:ed:bb:8f:5c:b2:f5:60:d0:18:1b:9e:2a:7a:3e:
         b3:6d:c6:bf:25:0f:04:15:9f:bb:46:fe:f0:a5:1c:77:8a:97:
         4d:f0:f6:f4:bc:e9:9d:f8:71:16:60:53:2c:30:85:14:c3:b8:
         ba:a9:bd:c3:98:58:f3:c6:b6:b3:cc:bb:25:66:5c:9e:0e:2c:
         b4:9b:c0:df:4a:e1:2b:f1:29:51:a0:84:a9:3e:90:e1:d0:2b:
         14:aa:97:2c:8b:a8:0a:d1:2c:4f:77:1d:b4:bb:b6:3a:ce:34:
         85:ff:f5:2c:96:fa:73:b4:de:a5:05:06:45:41:ca:20:4f:d7:
         ed:c8:bb:28:c4:51:44:65:cb:f2:95:c4:fd:e8:db:90:53:7b:
         b9:fb:74:a5:71:ed:c5:ee:8b:74:0f:48:32:07:dd:af:20:f8:
         0d:50:ed:33:97:12:f4:b7:e5:2e:7e:8a:35:c0:7d:4f:b0:06:
         a8:d7:6d:e3:22:b7:fb:17:d2:e9:cd:26:d1:87:34:ee:c4:2d:
         37:79:60:10:6e:37:f1:46:ff:e1:23:53:d4:64:9e:be:5c:54:
         47:4a:06:9a:58:54:a7:53:68:dc:7e:c6:3c:e2:f7:54:ca:2a:
         d1:db:8f:b1
```
The same procedure could be also done this way (Its location is normally /etc/kubernetes/pki/. In case of Minikube, it would be ~/.minikube/):

```text
root@master:# openssl x509 -req -in pidumenk.csr -CA /etc/kubernetes/pki/ca.crt -CAkey /etc/kubernetes/pki/ca.key -CAcreateserial -out pidumenk.crt -days 500

Signature ok
subject=CN = pidumenk
Getting CA Private Key
```

Let's create a role for pidumenk to allow this user working only with pods

```text
root@master:# k create role developer --verb=create,get,list,update,delete --resource=pods
role.rbac.authorization.k8s.io/developer created

root@master:# k describe role developer
Name:         developer
Labels:       <none>
Annotations:  <none>
PolicyRule:
  Resources  Non-Resource URLs  Resource Names  Verbs
  ---------  -----------------  --------------  -----
  pods       []                 []              [create get list update delete]
```

Now bind this role to pidumenk

```text
root@master:# k create rolebinding developer-binding-pidumenk --role=developer --user=pidumenk
rolebinding.rbac.authorization.k8s.io/developer-binding-pidumenk created

root@master:# k describe rolebinding developer-binding-pidumenk
Name:         developer-binding-pidumenk
Labels:       <none>
Annotations:  <none>
Role:
  Kind:  Role
  Name:  developer
Subjects:
  Kind  Name      Namespace
  ----  ----      ---------
  User  pidumenk
```

Note that even before creating user entries in kubeconfig we can test perms with `auth can-i`

```text
root@master:# k auth can-i get pods --as pidumenk
yes

root@master:# k auth can-i create services --as pidumenk
no
```

Create the user entry in kubeconfig

```text
root@master:# k config set-credentials pidumenk --client-certificate=pidumenk.crt --client-key=pidumenk.key --embed-certs=true
User "pidumenk" set.

root@master:# k config view
...
users:
- name: minikube
  user:
    client-certificate: REDACTED
    client-key: REDACTED
- name: pidumenk
  user:
    client-certificate-data: REDACTED
    client-key-data: REDACTED
```

Then finally create the context for pidumenk

```text
root@master:# k config set-context developer --cluster=minikube --user=pidumenk
Context "developer" created.

root@master:# k config view
...
contexts:
- context:
    cluster: minikube
    user: pidumenk
  name: developer
```

Last step is to switch to the newly created context developer and start working.

```text
root@master:# k config use-context developer
Switched to context "developer".

root@master:# k config get-contexts
CURRENT   NAME        CLUSTER    AUTHINFO   NAMESPACE
*         developer   minikube   pidumenk
          minikube    minikube   minikube   default

root@master:# k run nignx --image=nginx
pod/nginx created

root@master:# k expose pod nginx --name nginx-svc --port=80 --target-port=80
Error from server (Forbidden): services is forbidden: User "pidumenk" cannot create resource "services" in API group "" in the namespace "default"
```
It works!