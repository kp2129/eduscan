import { CameraView, CameraType, useCameraPermissions } from 'expo-camera';
import { useEffect, useState } from 'react';
import { Button, StyleSheet, Text, TouchableOpacity, View } from 'react-native';
import { logout, validateQR } from "../services/AuthServices";
import { useIsFocused } from '@react-navigation/native';

export default function App() {
  const [facing, setFacing] = useState('back');
  const [permission, requestPermission] = useCameraPermissions();
  const [scanned, setScanned] = useState(false);
  const [flashColor, setFlashColor] = useState('transparent'); 
  const [lastScannedQR, setLastScannedQR] = useState(null);
  const [scanTimeout, setScanTimeout] = useState(false); 
  const isFocused = useIsFocused();


  const handleBarCodeScanned = async ({ type, data }) => {
    if (scanTimeout || data === lastScannedQR) {
      return;
    }
    
    setScanTimeout(true);
    setScanned(true);
    setLastScannedQR(data); 

    try {
      const response = await validateQR(data);
      console.log('QR code scanned:', response);

      setFlashColor('rgba(0, 255, 0, 0.4)');
      setTimeout(() => setFlashColor('transparent'), 2000); 
    } catch (e) {
      console.log("Error", e);

      setFlashColor('rgba(255, 0, 0, 0.4)');
      setTimeout(() => setFlashColor('transparent'), 2000); 
    } finally {
      setScanned(false);
      setTimeout(() => setScanTimeout(false), 2000); 
    }
  };

  async function handleLogout() {
    await logout();
    setUser(null);
  }

  

  if (!permission) {
    return <View />;
  }

  if (!permission.granted) {
    return (
      <View style={styles.container}>
        <Text style={styles.message}>We need your permission to show the camera</Text>
        <Button onPress={requestPermission} title="grant permission" />
      </View>
    );
  }

  

  return (
    <View style={styles.container}>
       {isFocused && (
      <CameraView style={styles.camera} facing={facing}
        barcodeScannerSettings={{
          barcodeTypes: ['qr'],
        }}
        onBarcodeScanned={scanned ? undefined : handleBarCodeScanned}>
        <View style={styles.border} />
        <View style={[styles.flashOverlay, { backgroundColor: flashColor }]} />
      </CameraView>
       )}
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
  },
  message: {
    textAlign: 'center',
    paddingBottom: 10,
  },
  camera: {
    flex: 1,
  },
  buttonContainer: {
    flex: 1,
    flexDirection: 'row',
    backgroundColor: 'transparent',
    margin: 64,
  },
  button: {
    flex: 1,
    alignSelf: 'flex-end',
    alignItems: 'center',
  },
  text: {
    fontSize: 24,
    fontWeight: 'bold',
    color: 'white',
  },
  border: {
    position: 'absolute',
    top: '50%',
    left: '10%',
    right: '10%',
    height: 2,
    backgroundColor: 'white',
    zIndex: 10,
  },
  flashOverlay: {
    position: 'absolute',
    top: 0,
    bottom: 0,
    left: 0,
    right: 0,
    zIndex: 5,
  },
});
