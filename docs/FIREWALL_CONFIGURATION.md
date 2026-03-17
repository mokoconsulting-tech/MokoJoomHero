# Firewall Configuration for License Downloads

This document provides guidance on configuring firewalls to allow the automated license download workflow to access www.gnu.org.

## Overview

The `download-license.yml` GitHub Actions workflow automatically downloads the GPL-3.0 license from www.gnu.org. For enterprise environments with strict firewall rules, specific domains must be allowlisted to enable this functionality.

## Required Access

### Primary Domain
- **Domain:** `www.gnu.org`
- **Protocol:** HTTPS
- **Port:** 443
- **Purpose:** Primary source for GPL-3.0 license download

### Fallback Domain
- **Domain:** `ftp.gnu.org`
- **Protocol:** HTTPS
- **Port:** 443
- **Purpose:** Alternative source if primary is unavailable

## Firewall Configuration Examples

### iptables (Linux)

```bash
# Allow outbound HTTPS to www.gnu.org
iptables -A OUTPUT -p tcp -d www.gnu.org --dport 443 -j ACCEPT

# Allow outbound HTTPS to ftp.gnu.org (fallback)
iptables -A OUTPUT -p tcp -d ftp.gnu.org --dport 443 -j ACCEPT
```

### UFW (Uncomplicated Firewall)

```bash
# Allow outbound HTTPS to www.gnu.org
ufw allow out to www.gnu.org port 443 proto tcp

# Allow outbound HTTPS to ftp.gnu.org (fallback)
ufw allow out to ftp.gnu.org port 443 proto tcp
```

### firewalld (RHEL/CentOS/Fedora)

```bash
# Add www.gnu.org to allowed domains
firewall-cmd --permanent --direct --add-rule ipv4 filter OUTPUT 0 -p tcp -d www.gnu.org --dport 443 -j ACCEPT

# Add ftp.gnu.org to allowed domains
firewall-cmd --permanent --direct --add-rule ipv4 filter OUTPUT 0 -p tcp -d ftp.gnu.org --dport 443 -j ACCEPT

# Reload firewall
firewall-cmd --reload
```

### Windows Firewall

```powershell
# Allow outbound HTTPS to www.gnu.org
New-NetFirewallRule -DisplayName "Allow HTTPS to www.gnu.org" `
  -Direction Outbound `
  -RemoteAddress www.gnu.org `
  -Protocol TCP `
  -RemotePort 443 `
  -Action Allow

# Allow outbound HTTPS to ftp.gnu.org
New-NetFirewallRule -DisplayName "Allow HTTPS to ftp.gnu.org" `
  -Direction Outbound `
  -RemoteAddress ftp.gnu.org `
  -Protocol TCP `
  -RemotePort 443 `
  -Action Allow
```

## Network Security Groups (Cloud Providers)

### AWS Security Groups

```yaml
# Outbound rule for www.gnu.org
Type: HTTPS
Protocol: TCP
Port Range: 443
Destination: 0.0.0.0/0  # Or specific IP range if known
Description: Allow license download from www.gnu.org
```

### Azure Network Security Groups

```bash
az network nsg rule create \
  --resource-group myResourceGroup \
  --nsg-name myNSG \
  --name Allow-GNU-HTTPS \
  --protocol tcp \
  --priority 1000 \
  --destination-port-range 443 \
  --access Allow \
  --direction Outbound \
  --description "Allow HTTPS to www.gnu.org for license downloads"
```

### Google Cloud Platform

```bash
gcloud compute firewall-rules create allow-gnu-https \
  --direction=EGRESS \
  --priority=1000 \
  --network=default \
  --action=ALLOW \
  --rules=tcp:443 \
  --destination-ranges=0.0.0.0/0 \
  --description="Allow HTTPS to www.gnu.org for license downloads"
```

## Testing Connectivity

### Test DNS Resolution

```bash
nslookup www.gnu.org
```

Expected output should show IP addresses for www.gnu.org.

### Test HTTPS Connectivity

```bash
curl -I https://www.gnu.org/licenses/gpl-3.0.txt
```

Expected output should show HTTP 200 OK response.

### Full Download Test

```bash
curl -f -L -o GPL-3.0.txt https://www.gnu.org/licenses/gpl-3.0.txt
```

This should download the GPL-3.0 license without errors.

## Troubleshooting

### Connection Timeout

**Symptom:** `curl: (28) Connection timed out after 10000 milliseconds`

**Cause:** Firewall is blocking outbound connections to www.gnu.org

**Solution:**
1. Verify firewall rules are properly configured
2. Check if corporate proxy is required
3. Ensure DNS resolution is working
4. Contact network administrator to allowlist www.gnu.org

### DNS Resolution Failure

**Symptom:** `curl: (6) Could not resolve host: www.gnu.org`

**Cause:** DNS server cannot resolve www.gnu.org or DNS queries are blocked

**Solution:**
1. Test with `nslookup www.gnu.org`
2. Check DNS server configuration
3. Verify DNS queries (port 53) are not blocked
4. Try using alternate DNS (e.g., 8.8.8.8, 1.1.1.1)

### Certificate Verification Failed

**Symptom:** `curl: (60) SSL certificate problem`

**Cause:** SSL/TLS inspection or certificate validation issues

**Solution:**
1. Ensure system CA certificates are up-to-date
2. If using corporate SSL inspection, ensure root certificates are installed
3. Verify system time is correct (affects certificate validation)

## Proxy Configuration

If your enterprise environment uses a proxy server, configure the workflow to use it:

### GitHub Actions with Proxy

Add these environment variables to your workflow:

```yaml
env:
  HTTP_PROXY: http://proxy.example.com:8080
  HTTPS_PROXY: http://proxy.example.com:8080
  NO_PROXY: localhost,127.0.0.1
```

### Self-Hosted Runners

For self-hosted GitHub Actions runners, configure the proxy in the runner's environment:

```bash
# Linux/macOS
export HTTP_PROXY=http://proxy.example.com:8080
export HTTPS_PROXY=http://proxy.example.com:8080

# Windows
setx HTTP_PROXY "http://proxy.example.com:8080"
setx HTTPS_PROXY "http://proxy.example.com:8080"
```

## Security Considerations

### Minimal Permissions

The workflow uses the principle of least privilege:
- Only requires `contents: write` permission for committing the license
- No access to secrets or sensitive repository data
- Downloads only from trusted gnu.org domains

### Domain Verification

The workflow includes built-in verification:
1. DNS resolution check
2. HTTPS connectivity test
3. License content validation (checks for GPL-3.0 markers)
4. File integrity checks (size, format)

### Alternative: Manual License Management

If automated downloads are not possible due to security policies, you can:

1. **Manually download the license:**
   ```bash
   curl -o LICENSE https://www.gnu.org/licenses/gpl-3.0.txt
   ```

2. **Add copyright header:**
   Add your project's copyright information at the top of the LICENSE file

3. **Commit to repository:**
   ```bash
   git add LICENSE
   git commit -m "chore: add GPL-3.0 license"
   git push
   ```

4. **Disable the workflow:**
   Remove or comment out the workflow file `.github/workflows/download-license.yml`

## Support

For questions or issues related to firewall configuration:

1. Consult your organization's network security team
2. Review this documentation for common solutions
3. Check the workflow logs in GitHub Actions for specific error messages
4. Contact Moko Consulting: hello@mokoconsulting.tech

## References

- [GNU GPL-3.0 License](https://www.gnu.org/licenses/gpl-3.0.html)
- [GitHub Actions Documentation](https://docs.github.com/en/actions)
- [Firewall Best Practices](https://www.gnu.org/prep/maintain/html_node/Firewalls.html)
